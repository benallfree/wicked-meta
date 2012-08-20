<?

W::register_action('meta_value_serialize', function($m) {
  $v = json_encode(W::utf8_deep_encode($m->value));
  if($v===false) W::error(json_last_error());
  $m->value = $v;
});

W::register_action('meta_value_unserialize', function($m) {
  $m->value = json_decode($m->value, true);
});

W::add_mixin('MetaMixin');

require('codegen.php');