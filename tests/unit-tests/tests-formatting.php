<?php

/**
 * @group formatting
 */
class Tests_Formatting extends Give_Unit_Test_Case {
	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}


	/**
	 * Test give_get_cache_key function.
	 *
	 * @since 1.8
	 *
	 * @cover give_get_cache_key
	 */
	function test_give_get_cache_key() {
		// Action.
		$input_action = 'get_log_count';

		// Basic query param.
		$input_query_args = array(
			'post_parent'    => 1024,
			'post_type'      => 'give_log',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'fields'         => 'ids',
		);

		$output = give_get_cache_key( $input_action, $input_query_args );

		$this->assertEquals( 'give_cache_get_log_count_01f5c4012ed8142', $output );
	}

	/**
	 * Test give_clean() - note this is a basic type test as WP core already.
	 * has coverage for sanitized_text_field().
	 *
	 * @since 1.8
	 * @cover give_clean
	 */
	public function test_give_clean() {
		$this->assertEquals( 'cleaned', give_clean( '<script>alert();</script>cleaned' ) );
	}


	/**
	 * Test give_let_to_num function.
	 *
	 * @since        1.8
	 *
	 * @cover        give_let_to_num
	 * @dataProvider give_let_to_num_provider
	 *
	 * @param  string $size
	 * @param  int    $expected
	 * @param  string $message
	 */
	public function test_give_let_to_num( $size, $expected, $message ) {
		$output = give_let_to_num( $size );
		$this->assertSame(
			$expected,
			$output,
			$message
		);
	}


	/**
	 * Data provider for give_let_to_num function.
	 *
	 * @since 1.8
	 * @return array
	 */
	public function give_let_to_num_provider() {
		return array(
			array( '1P', 1125899906842624, '1P should be equal to 1125899906842624' ),
			array( '1T', 1099511627776, '1T should be equal to 1099511627776' ),
			array( '1G', 1073741824, '1G should be equal to 1073741824' ),
			array( '1M', 1048576, '1M should be equal to 1048576' ),
			array( '1K', 1024, '1K should be equal to 1024' ),
		);
	}
}