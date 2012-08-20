# Meta

## Overview

The `meta` module adds metadata capability to every ActiveRecord model.

Metadata can often take the place of real database fields. 

## Example usage

`ActiveRecordBase::meta($key, $default_value = null)`

`ActiveRecordBase::set_meta($key, $value)`

## Functions

`meta($key, $default_value=null)`

Retrieve the meta value by key name. If the key is not present, `$default_value` will be returned. The value will be stored using `set_meta()`.

`set_meta($key, $value)`

Set a meta key to a given value. The value must be serializable using JSON.

