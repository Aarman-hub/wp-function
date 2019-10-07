//register form
    /* To add WooCommerce registration form custom fields. */
    function WC_extra_registation_fields() {?>
        <p class="form-row form-row-first">
            <label for="reg_billing_gender"><?php _e( 'Gender', 'woocommerce' ); ?></label>
            <select class="input-text" name="billing_gender" id="reg_billing_gender"> 
            <option <?php if ( ! empty( $_POST['billing_gender'] ) && $_POST['billing_gender'] == 'male') esc_attr_e( 'selected' ); ?> value="male">Male</option> 
            <option <?php if ( ! empty( $_POST['billing_gender'] ) && $_POST['billing_gender'] == 'female') esc_attr_e( 'selected' ); ?> value="female">Female</option>
            <option <?php if ( ! empty( $_POST['billing_gender'] ) && $_POST['billing_gender'] == 'other') esc_attr_e( 'selected' ); ?> value="other">Other</option>
            </select> 
        </p>
        <p class="form-row form-row-last">
            <label for="reg_billing_phone"><?php _e( 'Phone Number', 'woocommerce' ); ?> <span class="required">*</span></label></label>
            <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
        </p>
        <div class="clear"></div>
        <p class="form-row form-row-wide">
            <label for="reg_user_hearaboutus"><?php _e( 'How Did You Hear About Us?', 'woocommerce' ); ?> <span class="required">*</span></label>
            <label style="float: left; margin-right: 10px;font-weight: normal;" for="from_facebook">
            <input <?php checked( $_POST['user_hearaboutus'], 'facebook', true ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_facebook" value="facebook"> Facebook</label>
            <label style="float: left; margin-right: 10px;font-weight: normal;" for="from_twitter">
            <input <?php checked( $_POST['user_hearaboutus'], 'twitter' ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_twitter" value="twitter"> Twitter</label>
            <label style="float: left; margin-right: 10px;font-weight: normal;" for="from_google">
            <input <?php checked( $_POST['user_hearaboutus'], 'google' ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_google" value="google"> Google</label>
            <label style="float: left; margin-right: 10px;font-weight: normal;" for="from_friends">
            <input <?php checked( $_POST['user_hearaboutus'], 'friends' ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_friends" value="friends"> Friends</label>
            <label style="float: left; margin-right: 10px;font-weight: normal;" for="from_emails">
            <input <?php checked( $_POST['user_hearaboutus'], 'emails' ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_emails" value="emails"> Newsletters</label>
        </p>
        <div class="clear"></div>
        <?php
    }
    add_action( 'woocommerce_register_form', 'WC_extra_registation_fields');

//***//
    /* To validate WooCommerce registration form custom fields.  */
    function WC_validate_reg_form_fields($username, $email, $validation_errors) {
        if (isset($_POST['billing_phone']) && empty($_POST['billing_phone']) ) {
            $validation_errors->add('billing_phone_error', __('Phone number is required!', 'woocommerce'));
        }
        /*if (isset($_POST['billing_phone']) && !is_numeric($_POST['billing_phone'])) {
            $validation_errors->add('billing_phone_error', __('Valid Phone number is required!', 'woocommerce'));
        }*/
        if (!isset($_POST['user_hearaboutus']) || empty($_POST['user_hearaboutus'])) {
            $validation_errors->add('user_hearaboutus_error', __('Please select how did you hear about us!', 'woocommerce'));
        }
        return $validation_errors;
    }
    add_action('woocommerce_register_post', 'WC_validate_reg_form_fields', 10, 3);

//**//
    /* To save WooCommerce registration form custom fields. */
    function WC_save_registration_form_fields($customer_id) {
        
        //Gender field
        if (isset($_POST['billing_gender'])) {
            update_user_meta($customer_id, 'billing_gender', sanitize_text_field($_POST['billing_gender']));
        }
        //Phone field
        if (isset($_POST['billing_phone'])) {
            update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
        }
        //Hear about us field
        if (isset($_POST['user_hearaboutus']) && !empty($_POST['user_hearaboutus'])) {
            update_user_meta($customer_id, 'user_hearaboutus', sanitize_text_field($_POST['user_hearaboutus']));
        }
    }
    add_action('woocommerce_created_customer', 'WC_save_registration_form_fields');

/**/
    function WC_edit_account_form() {
        $user_id = get_current_user_id();
        $current_user = get_userdata( $user_id );
        if (!$current_user) return;
        $billing_gender = get_user_meta( $user_id, 'billing_gender', true );
        $billing_phone = get_user_meta( $user_id, 'billing_phone', true );
        $user_hearaboutus = get_user_meta( $user_id, 'user_hearaboutus', true );
        ?>
        
        <fieldset>
            <legend>Other information</legend>
            <p class="form-row form-row-first">
            <label for="reg_billing_gender"><?php _e( 'Gender', 'woocommerce' ); ?></label>
            <select class="input-text" name="billing_gender" id="reg_billing_gender">
                <option <?php if ( esc_attr($billing_gender) == 'male') esc_attr_e( 'selected' ); ?> value="male">Male</option>
                <option <?php if ( esc_attr($billing_gender) == 'female') esc_attr_e( 'selected' ); ?> value="female">Female</option>
                <option <?php if ( esc_attr($billing_gender) == 'other') esc_attr_e( 'selected' ); ?> value="other">Other</option>
            </select>
            </p>
            <p class="form-row form-row-last">
                <label for="reg_billing_phone"><?php _e( 'Phone Number', 'woocommerce' ); ?> <span class="required">*</span></label></label>
                <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php echo esc_attr($billing_phone); ?>" />
            </p>
            <div class="clear"></div>
            <p class="form-row form-row-wide">
                <label for="reg_user_hearaboutus"><?php _e( 'How Did You Hear About Us?', 'woocommerce' ); ?> <span class="required">*</span></label>
                <label for="from_facebook">
                    <input <?php checked( esc_attr($user_hearaboutus), 'facebook', true ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_facebook" value="facebook"> Facebook
                </label>
                <label for="from_twitter">
                    <input <?php checked( esc_attr($user_hearaboutus), 'twitter' ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_twitter" value="twitter"> Twitter
                </label>
                <label for="from_google">
                    <input <?php checked( esc_attr($user_hearaboutus), 'google' ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_google" value="google"> Google
                </label>
                <label for="from_friends">
                    <input <?php checked( esc_attr($user_hearaboutus), 'friends' ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_friends" value="friends"> Friends
                </label>
                <label for="from_emails">
                    <input <?php checked( esc_attr($user_hearaboutus), 'emails' ); ?> class="input-radio" type="radio" name="user_hearaboutus" id="from_emails" value="emails"> Newsletters
                </label>
            </p>
            <div class="clear"></div>
        </fieldset>
        <?php
    }
    function WC_save_account_details( $user_id ) {
        //Gender field
        update_user_meta($user_id, 'billing_gender', sanitize_text_field($_POST['billing_gender']));
        //Phone field
        update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
        //Hear about us field
        update_user_meta($user_id, 'user_hearaboutus', sanitize_text_field($_POST['user_hearaboutus']));
    }
    add_action( 'woocommerce_edit_account_form', 'WC_edit_account_form' );
    add_action( 'woocommerce_save_account_details', 'WC_save_account_details' );
//*********************//

