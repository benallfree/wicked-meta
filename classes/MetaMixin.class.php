<?

class MetaMixin extends Mixin
{
  static $type_cache = array();
  static $value_cache = array();
  
  static function meta_get($o, $name, $default=null)
  {
    if(!$o->id) return $default;
    $m = self::_meta_get($o, $name, $default);
    return $m->value;
  }
  
  static function meta_set($o, $name, $v)
  {
    if(!$o->id) return $v;
    $m = self::_meta_get($o, $name, $v);
    $m->value = $v;
    $m->save();
    return $m->value;
  }
  
  
  private static function _meta_get_type($o,$name)
  {
    $cache = &self::$type_cache;
    $class = get_class($o);
    if(!isset($cache[$class])) $cache[$class] = array();
    if(isset($cache[$class][$name])) return $cache[$class][$name];
    
    $type = MetaType::find_or_create_by(array(
      'conditions'=>array('object_type = ? and name = ?', $class, $name),
      'attributes'=>array(
        'object_type'=>$class,
        'data_type'=>'string',
        'name'=>$name,
        'autoload'=>false,
      ),
    ));
    $cache[$class][$name] = $type;
  
    if($type->autoload)
    {
      $all_metas = $type->meta_values;
      $value_cache = &self::$value_cache;
      $value_cache[$type->id] = array();
      foreach($all_metas as $m)
      {
        $value_cache[$type->id][$o->id] = $m;
      }
    }  
    return $type;
  }
  
  private static function _meta_get_value($o, $type, $default)
  {
    $cache = &self::$value_cache;
    $class = get_class($o);
    if(!isset($cache[$type->id])) $cache[$type->id] = array();
    if(isset($cache[$type->id][$o->id])) return $cache[$type->id][$o->id];
    
    $m = MetaValue::find_or_create_by( array(
      'conditions'=>array('type_id = ? and object_id = ?', $type->id, $o->id),
      'attributes'=>array(
        'type_id'=>$type->id,
        'object_id'=>$o->id,
        'value'=>$default,
      ),
    ));
    $cache[$type->id][$o->id] = $m;
    return $m;
  }
  
  private static function _meta_get($o, $name, $default)
  {
    $type = self::_meta_get_type($o,$name);
    $value = self::_meta_get_value($o, $type, $default);
    return $value;
  }
  
}
