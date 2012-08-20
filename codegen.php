<?

$ar_config = W::module('activerecord');
foreach($ar_config['model_info'] as $class=>$info)
{
  call_user_func("$class::add_function", "meta", 'W::meta_get');
  call_user_func("$class::add_function", "set_meta", 'W::meta_set');
}