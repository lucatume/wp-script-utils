# WordPress script and style utilities

*A small library to allow easy manipulation and enqueing of scripts and styles in WordPress.*

## Installation
The library is meant to be used as a WordPress plugin (or mu-plugin) so copy it in the WordPress mu-plugins or plugins folder.  
If using [Composer](https://getcomposer.org/) the plugin can be pulled into the project

	composer require lucatume/wp-script-utils
	
## Usage

### JavaScript hooks
The plugin will register and enqueue on the front-end and the back-end of the WordPress site, a script with the `js-hooks` handle, that script will allow for any other script to rely and run on a Backbone Events based hooking system similar to WordPress hooks, code like this

	(function($){
		
		$(document).ready(function(){
			// do my thing
		});

	})(jQuery)

could be rewritten like this	

	(function($){
		
		window.hookBus.on('initUi:10',function(){
			// do my thing
		});

	})(jQuery)

where the advantage is the same offered by the WordPress hook mechanism: certainety of run sequence. The order scripts are printed on the page becomes irrelevant as long as dependencies are in place, and each hook run will handle exceptions and their logging to a point that's not keeping anyone from proper exception handling.  
There are three hooks running in the sequence `initBase`, `initFunctional`, `initUi` each with a 0 to 10 priority, so the run order, Backbone Events, will be:

* `initBase:1`
* `initBase:2`
* `initBase:3`
* ...
* `initBase:10`
* `initFunctional:1`
* `initFunctional:2`
* `initFunctional:3`
* ...
* `initFunctional:10`
* `initUi:1`
* `initUi:2`
* `initUi:3`
* ...
* `initUi:10`

### JavaScript additions
I've packed in the plugin the small code snippets I find myself writing over and over to write it no more.

#### CMB2 related scripts
A collection of scripts aimed at modifying or extending [Custom Meta Boxes 2](https://github.com/webdevstudios/CMB2) functionalities, I will add those as I need them; enqueue those in a plugin using the handle; all are using the JavaScript hooks mechanism.

* `cmb2-checkbox-toggle` - hooks at `initUi:5`, will show/hide a row when a checkbox is checked/unchecked; the checkbox must define the `data-toggle-target` attribute
	
		add_action( 'cmb2_init', 'add_my_metabox' );
		function add_my_metabox() {
			$mb = new_cmb2_box( [
				'id'           => 'post_settings',
				'title'        => 'Settings',
				'object_types' => [ 'post' ],
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true
			] );
			$mb->add_field( [
				'name'       => 'A visibility toggle',
				'id'         => 'toggle',
				'type'       => 'checkbox',
				'default'    => 'on',
				'attributes' => [
					'data-toggle-target' => 'toggled-setting' // dash separated!
					'data-toggle-target' => 'toggled-setting,another-setting,foo-setting' // can be a list
					'data-invert-toggle-target' => 'toggled-setting' // inverse logic: show when unchecked, hide when checked
					'data-invert-toggle-target' => 'toggled-setting,foo-setting,another-setting' //  this too can be a list 
				]
			] );
			$mb->add_field( [
				'name' => 'Toggled setting',
				'id'   => 'toggled_setting',
				'type' => 'text'
			] );
		}

### Getting proper source
WordPress allows developers to set the `SCRIPT_DEBUG` constant to let WordPress know that the session is a script debug one; once the `Scripts` class is instantiated on a root folder scripts and styles can be pulled in their normal or minified form with no additional effort.
	
	// initialize the class on the /assets folder
	$scripts = Scripts::instance(plugins_url('/assets',__FILE__);
	
	define('SCRIPT_DEBUG', true);
	
	// will return `http://mysite/wp/wp-content/plugins/my-plugin/assets/css/style.css`
	$style_src = $scripts->get_src('/css/style.css');
	
	// will return `http://mysite/wp/wp-content/plugins/my-plugin/assets/js/site.js`
	$js_src = $scripts->get_src('/js/site.js');
	
	define('SCRIPT_DEBUG', true);
	
	// will return `http://mysite/wp/wp-content/plugins/my-plugin/assets/css/style.css`
	$style_src = $scripts->get_src('/css/style.css');
	
	// will return `http://mysite/wp/wp-content/plugins/my-plugin/assets/js/site.js`
	$js_src = $scripts->get_src('/js/site.js');

### Getting a file using just relative paths
Some files just come minified and/or are not to be scrutinized in a debug session, that's why the `get` method is there

	define('SCRIPT_DEBUG', true);
	
	// will return `http://mysite/wp/wp-content/plugins/my-plugin/assets/vendor/vendor-style.min.css`
	$style_src = $scripts->get_src('/vendor/vendor-style.min.css');
	
	// will return `http://mysite/wp/wp-content/plugins/my-plugin/assets/vendor/vendor-script.min.js`
	$js_src = $scripts->get_src('/vendor/vendor-script.min.js');

