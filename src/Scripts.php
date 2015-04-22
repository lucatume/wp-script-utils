<?php


	class Scripts {

		/**
		 * @var Scripts
		 */
		protected $instance;

		/**
		 * @var string
		 */
		protected $root_path;

		/**
		 * @param $path
		 *
		 * @return string
		 */
		protected function r_format_path( $path ) {
			return rtrim( $path, '/' ) . '/';
		}

		/**
		 * @param $root_path
		 *
		 * @return Scripts
		 */
		public function instance( $root_path ) {
			$instance = new self;

			$instance->set_root_path( $root_path );

			return $instance;
		}

		/**
		 * @param $src
		 *
		 * @return string
		 */
		public function get_src( $src ) {
			Arg::_( $src, 'Source file' )->is_string()
			   ->assert( is_file( $src ), 'Source file must be an existing file.' );

			$type = $this->get_type( $src );

			if ( ! $type ) {
				return $src;
			}

			$src = $this->l_format_path( $src );

			$prefix = $this->get_min_prefix();

			return $this->root_path . str_replace( '.' . $type, $prefix . '.' . $type, $src );
		}

		/**
		 * @param $root_path
		 */
		public function set_root_path( $root_path ) {
			Arg::_( $root_path, 'Root path' )->is_string();

			if ( $this->is_file( $root_path ) ) {
				$root_path = dirname( $root_path );
			}

			$this->root_path = $this->r_format_path( $root_path );
		}

		/**
		 * @param $src
		 *
		 * @return bool
		 */
		protected function get_type( $src ) {
			$extension = pathinfo( $src )['extension'];
			if ( in_array( $extension, array( 'js', 'css' ) ) ) {
				return $extension;
			}

			return false;
		}

		/**
		 * @param $src
		 *
		 * @return string
		 */
		protected function l_format_path( $src ) {
			$src = ltrim( $src, '/' );

			return $src;
		}

		/**
		 * @return string
		 */
		protected function get_min_prefix() {
			$prefix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			return $prefix;
		}

		private function is_file( $path ) {
			$info = pathinfo( $path );

			return empty( $info['extension'] ) ? false : true;
		}

	}
