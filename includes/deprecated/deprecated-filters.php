<?php
/**
 * Handle renamed filters
 */
$give_map_deprecated_filters = give_deprecated_filters();

foreach ( $give_map_deprecated_filters as $new => $old ) {
	add_filter( $new, 'give_deprecated_filter_mapping', 10, 4 );
}

/**
 * Deprecated filters.
 *
 * @return array An array of deprecated Give filters.
 */
function give_deprecated_filters() {

	$give_deprecated_filters = array(
		// New filter hook                               Old filter hook.
		'give_donation_data_before_gateway'          => 'give_purchase_data_before_gateway',
		'give_donation_form_required_fields'         => 'give_purchase_form_required_fields',
		'give_donation_stats_by_user'                => 'give_purchase_stats_by_user',
		'give_donation_from_name'                    => 'give_purchase_from_name',
		'give_donation_from_address'                 => 'give_purchase_from_address',
		'give_get_users_donations_args'              => 'give_get_users_purchases_args',
		'give_recount_donors_donation_statuses'      => 'give_recount_customer_payment_statuses',
		'give_donor_recount_should_process_donation' => 'give_customer_recount_should_process_payment',
		'give_reset_items'                           => 'give_reset_store_items',
	);

	// Dynamic filters.
	switch ( true ) {
		case ( ! empty( $_GET['payment-confirmation'] ) ) :
			$give_deprecated_filters["give_donation_confirm_{$_GET['payment-confirmation']}"] = "give_payment_confirm_{$_GET['payment-confirmation']}";
	}

	return $give_deprecated_filters;
}

/**
 * Deprecated filter mapping.
 *
 * @param mixed  $data
 * @param string $arg_1
 * @param string $arg_2
 * @param string $arg_3
 *
 * @return mixed|void
 */
function give_deprecated_filter_mapping( $data, $arg_1 = '', $arg_2 = '', $arg_3 = '' ) {
	$give_map_deprecated_filters = give_deprecated_filters();
	$filter                      = current_filter();

	if ( isset( $give_map_deprecated_filters[ $filter ] ) ) {
		if ( has_filter( $give_map_deprecated_filters[ $filter ] ) ) {
			$data = apply_filters( $give_map_deprecated_filters[ $filter ], $data, $arg_1, $arg_2, $arg_3 );

			if ( ! defined( 'DOING_AJAX' ) ) {
				_give_deprecated_function(
					sprintf(
					/* translators: %s: filter name */
						__( 'The %s filter' ),
						$give_map_deprecated_filters[ $filter ]
					),
					'1.7',
					$filter
				);
			}
		}
	}

	return $data;
}
