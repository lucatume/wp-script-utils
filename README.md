# WordPress script and style utilities

*A small library to allow easy manipulation and enqueing of scripts and styles in WordPress.*

## Installation
The library is meant to be used as a WordPress plugin (or mu-plugin) so copy it in the WordPress mu-plugins or plugins folder.  
If using [Composer](https://getcomposer.org/) the plugin can be pulled into the project

	composer require lucatume/wp-script-utils
	
## Usage

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
