<?php

	class Cache {

		function Cache(){
			$this->host = "127.0.0.1";
			$this->port = 11211;
			$this->expire = 7200;
			$this->connected_server = array();
			$this->_connect();
		}
		
		function _connect(){
			if(function_exists('memcache_connect')){
				$this->memcache = new Memcache;
				$this->_connect_memcached();
			}
		}

		function _connect_memcached(){
			$error_display = ini_get('display_errors');
			$error_reporting = ini_get('error_reporting');
			if($this->memcache->addServer($this->host, $this->port)) $this->connected_server = $this->host;
			ini_set('error_reporting', $error_reporting);
		}

		function get($key){
			if(empty($this->connected_server)) return false;
			return $this->memcache->get($key);
		}

		function set($key,$data){
			if(empty($this->connected_server)) return false;
			return $this->memcache->set($key, $data, 0, $this->expire);
		}

		function replace($key,$data){
			if(empty($this->connected_server)) return false;
			return $this->memcache->replace($key, $data, 0, $this->expire);
		}

		function delete($key,$when = 0){
			if(empty($this->connected_server)) return false;
			return $this->memcache->delete($key, $when);
		}

	}