<?php
/**
 * BuddyBoss - Create Meeting
 *
 * @since 1.0.0
 */
?>
<div class="bb-title-wrap">
	<h2 class="bb-title"><?php _e( 'Create Meeting', 'buddyboss-pro' ); ?></h2>
	<a href="#" class="bp-close-create-meeting-form"><span class="bb-icon-x"></span></a>
</div>
<?php
$group_id         = filter_input( INPUT_GET, 'group_id', FILTER_VALIDATE_INT );
$current_group_id = bp_is_group() ? bp_get_current_group_id() : false;
if ( ! empty( $current_group_id ) ) {
	$group_id = $current_group_id;
}

if ( ! bp_zoom_is_group_setup( $group_id ) ) {
	$group_link         = bp_get_group_permalink( groups_get_group( $group_id ) );
	$zoom_settings_link = trailingslashit( $group_link . 'admin/zoom' );
	?>
    <div class="bp-feedback error">
        <span class="bp-icon" aria-hidden="true"></span>
        <p>
			<?php printf( __( 'This group does not have Zoom properly configured. Please update the %s.', 'buddyboss-pro' ),
				'<a href="' . $zoom_settings_link . '">' . __( 'Zoom settings', 'buddyboss-pro' ) . '</a>'
			); ?>
        </p>
    </div>
	<?php
	return false;
}

$current_user_data = get_userdata( get_current_user_id() );
if ( empty( $current_user_data ) ) {
	return false;
}

$default_group_host_email = groups_get_groupmeta( $group_id, 'bp-group-zoom-api-email', true );

$disable_registration = false;
$disable_recording    = false;
$disable_alt_host     = false;
$host_type            = groups_get_groupmeta( $group_id, 'bp-group-zoom-api-host-type', true );
if ( 1 === (int) $host_type ) {
	$disable_registration = true;
	$disable_recording    = true;
	$disable_alt_host     = true;
}
?>
<div class="bp-meeting-fields-wrap">
    <div class="bb-field-wrapper">
		<div class="bb-field-wrapper-inner">
			<div class="bb-field-wrap">
				<label for="bp-zoom-meeting-title"><?php _e( 'Meeting Title', 'buddyboss-pro' ); ?>*</label>
				<div class="bb-meeting-input-wrap">
					<input autocomplete="off" type="text" id="bp-zoom-meeting-title" value="" name="bp-zoom-meeting-title" />
				</div>
			</div>

            <div class="bb-field-wrap">
                <label for="bp-zoom-meeting-description"><?php _e( 'Description (optional)', 'buddyboss-pro' ); ?></label>
				<div class="bb-meeting-input-wrap">
					<textarea id="bp-zoom-meeting-description" name="bp-zoom-meeting-description"></textarea>
				</div>
            </div>

			<div class="bb-field-wrap">
				<label for="bp-zoom-meeting-password"><?php _e( 'Password (optional)', 'buddyboss-pro' ); ?></label>
				<div class="bb-meeting-input-wrap bp-toggle-meeting-password-wrap">
					<a href="#" class="bp-toggle-meeting-password"><i class="bb-icon-eye"></i><i class="bb-icon-eye-off"></i></a>
					<input autocomplete="new-password" type="password" id="bp-zoom-meeting-password" value="" name="bp-zoom-meeting-password" />
				</div>
			</div>
		</div>

		<hr />

		<div class="bb-field-wrapper-inner">
			<div class="bb-field-wrap">
				<label for="bp-zoom-meeting-start-date"><?php _e( 'When', 'buddyboss-pro' ); ?>*</label>
				<div class="bp-wrap-duration bb-meeting-input-wrap">
					<div class="bb-field-wrap start-date-picker">
						<input type="text" id="bp-zoom-meeting-start-date" value="<?php echo wp_date( 'Y-m-d', strtotime( 'now' ) ); ?>" name="bp-zoom-meeting-start-date" placeholder="yyyy-mm-dd" autocomplete="off" />
					</div>
					<div class="bb-field-wrap start-time-picker">
                        <?php
                        $pending_minutes = 60 - wp_date( 'i', strtotime( 'now' ) );
                        $current_minutes = strtotime( '+ ' . $pending_minutes . ' minutes' );
                        ?>
						<input type="text" id="bp-zoom-meeting-start-time" name="bp-zoom-meeting-start-time" autocomplete="off" placeholder="hh:mm" value="<?php echo wp_date( 'h:i', $current_minutes ); ?>" autocomplete="off" />
					</div>
					<div class="bb-field-wrap bp-zoom-meeting-time-meridian-wrap">
						<label for="bp-zoom-meeting-start-time-meridian-am">
							<input type="radio" value="am" id="bp-zoom-meeting-start-time-meridian-am" name="bp-zoom-meeting-start-time-meridian" <?php checked( 'AM', wp_date( 'A', strtotime( 'now' ) ) ); ?>>
							<span class="bb-time-meridian"><?php _e( 'AM', 'buddyboss-pro' ); ?></span>
						</label>
						<label for="bp-zoom-meeting-start-time-meridian-pm">
							<input type="radio" value="pm" id="bp-zoom-meeting-start-time-meridian-pm" name="bp-zoom-meeting-start-time-meridian" <?php checked( 'PM', wp_date( 'A', strtotime( 'now' ) ) ); ?>>
							<span class="bb-time-meridian"><?php _e( 'PM', 'buddyboss-pro' ); ?></span>
						</label>
					</div>
				</div>
			</div>

			<div class="bb-field-wrap">
				<label for="bp-zoom-meeting-duration"><?php _e( 'Duration', 'buddyboss-pro' ); ?>*</label>
				<div class="bp-wrap-duration bb-meeting-input-wrap">
					<div class="bb-field-wrap">
						<select id="bp-zoom-meeting-duration-hr" name="bp-zoom-meeting-duration-hr">
							<?php
							for ( $hr = 0; $hr <= 24; $hr ++ ) {
								echo '<option value="' . esc_attr( $hr ) . '">' . esc_attr( $hr ) . '</option>';
							} ?>
						</select>
						<label for="bp-zoom-meeting-duration-hr"><?php _e( 'hr', 'buddyboss-pro' ); ?></label>
					</div>
					<div class="bb-field-wrap">
						<select id="bp-zoom-meeting-duration-min" name="bp-zoom-meeting-duration-min">
							<?php
							$min = 0;
							while ( $min <= 45 ) {
								echo '<option value="' . esc_attr( $min ) . '">' . esc_attr( $min ) . '</option>';
								$min = $min + 15;
							}
							?>
						</select>
						<label for="bp-zoom-meeting-duration-min"><?php _e( 'min', 'buddyboss-pro' ); ?></label>
					</div>
				</div>
			</div>

			<div class="bb-field-wrap">
				<label for="bp-zoom-meeting-timezone"><?php _e( 'Timezone', 'buddyboss-pro' ); ?>*</label>
				<div class="bb-meeting-input-wrap">
					<select id="bp-zoom-meeting-timezone" name="bp-zoom-meeting-timezone">
						<?php
						$timezones          = bp_zoom_get_timezone_options();
						$wp_timezone_str    = get_option( 'timezone_string' );
						$selected_time_zone = '';

						if ( empty( $wp_timezone_str ) ) {
							$wp_timezone_str_offset = get_option( 'gmt_offset' );
						} else {
							$time                   = new DateTime( 'now', new DateTimeZone( $wp_timezone_str ) );
							$wp_timezone_str_offset = $time->getOffset() / 60 / 60;
						}

						if ( ! empty( $timezones ) ) {
							foreach ( $timezones as $key => $time_zone ) {
								if ( $key === $wp_timezone_str ) {
									$selected_time_zone = $key;
									break;
								}

								$date            = new DateTime( 'now', new DateTimeZone( $key ) );
								$offset_in_hours = $date->getOffset() / 60 / 60;

								if ( (float) $wp_timezone_str === (float) $offset_in_hours ) {
									$selected_time_zone = $key;
								}
							}
						}
						?>
						<?php foreach ( $timezones as $k => $timezone ) { ?>
							<option value="<?php echo $k; ?>" <?php echo $k === $selected_time_zone ? 'selected="selected"' : ''; ?>><?php echo $timezone; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>

		<hr />

		<div class="bb-field-wrapper-inner">
			<div class="bb-field-wrap">
				<label class="bb-video-label"><?php _e( 'Video', 'buddyboss-pro' ); ?></label>
				<div class="bb-video-fields-wrap bb-meeting-input-wrap">
					<div class="bb-field-wrap checkbox-row">
						<label for="bp-zoom-meeting-host-video">
							<span class="label-span"><?php _e( 'Host', 'buddyboss-pro' ); ?></span>
							<div class="bb-toggle-switch">
								<input type="checkbox" id="bp-zoom-meeting-host-video" value="yes" name="bp-zoom-meeting-host-video" class="bs-styled-checkbox"/>
								<span class="bb-toggle-slider"></span>
							</div>
						</label>
					</div>

					<div class="bb-field-wrap checkbox-row">
						<label for="bp-zoom-meeting-participants-video">
							<span class="label-span"><?php _e( 'Participants', 'buddyboss-pro' ); ?></span>
							<div class="bb-toggle-switch">
								<input type="checkbox" id="bp-zoom-meeting-participants-video" value="yes" name="bp-zoom-meeting-participants-video" class="bs-styled-checkbox"/>
								<span class="bb-toggle-slider"></span>
							</div>
						</label>
					</div>
                    <p class="description"><?php _e( 'Start video when host and participants join the meeting.', 'buddyboss-pro' ); ?></p>
				</div>
			</div>
		</div>

		<hr />

		<div class="bb-field-wrapper-inner">
			<div class="bb-field-wrap">
				<label><?php _e( 'Meeting Options', 'buddyboss-pro' ); ?></label>
				<div class="bb-meeting-options-wrap bb-meeting-input-wrap">
                    <?php if ( ! $disable_registration ) : ?>
                        <div class="bb-field-wrap checkbox-row">
                            <input type="checkbox" name="bp-zoom-meeting-registration" id="bp-zoom-meeting-registration" value="yes" class="bs-styled-checkbox" />
                            <label for="bp-zoom-meeting-registration"><span><?php _e( 'Require Registration', 'buddyboss-pro' ); ?></span></label>
                        </div>
                    <?php endif; ?>

					<div class="bb-field-wrap checkbox-row">
						<input type="checkbox" id="bp-zoom-meeting-join-before-host" value="yes" name="bp-zoom-meeting-join-before-host" class="bs-styled-checkbox"/>
						<label for="bp-zoom-meeting-join-before-host"><span><?php _e( 'Enable join before host', 'buddyboss-pro' ); ?></span></label>
					</div>

					<div class="bb-field-wrap checkbox-row">
						<input type="checkbox" id="bp-zoom-meeting-mute-participants" value="yes" name="bp-zoom-meeting-mute-participants" class="bs-styled-checkbox"/>
						<label for="bp-zoom-meeting-mute-participants"><span><?php _e( 'Mute participants upon entry', 'buddyboss-pro' ); ?></span></label>
					</div>

					<div class="bb-field-wrap checkbox-row">
						<input type="checkbox" id="bp-zoom-meeting-waiting-room" value="yes" name="bp-zoom-meeting-waiting-room" class="bs-styled-checkbox"/>
						<label for="bp-zoom-meeting-waiting-room"><span><?php _e( 'Enable waiting room', 'buddyboss-pro' ); ?></span></label>
					</div>

					<div class="bb-field-wrap checkbox-row">
						<input type="checkbox" id="bp-zoom-meeting-authentication" value="yes" name="bp-zoom-meeting-authentication" class="bs-styled-checkbox"/>
						<label for="bp-zoom-meeting-authentication"><span><?php _e( 'Only authenticated users can join', 'buddyboss-pro' ); ?></span></label>
					</div>

					<div class="bb-field-wrap full-row">
                        <?php if ( ! $disable_recording ) : ?>
                            <input type="checkbox" id="bp-zoom-meeting-auto-recording" value="yes" name="bp-zoom-meeting-auto-recording" class="bs-styled-checkbox"/>
                            <label for="bp-zoom-meeting-auto-recording"><span><?php _e( 'Record the meeting automatically', 'buddyboss-pro' ); ?></span></label>

                            <div class="bp-zoom-meeting-auto-recording-options bp-hide">
                                <input type="radio" value="local" id="bp-zoom-meeting-recording-local" name="bp-zoom-meeting-recording" class="bs-styled-radio" checked/>
                                <label for="bp-zoom-meeting-recording-local"><span><?php _e( 'On the local computer', 'buddyboss-pro' ); ?></span></label>
                                <input type="radio" value="cloud" id="bp-zoom-meeting-recording-cloud" name="bp-zoom-meeting-recording" class="bs-styled-radio"/>
                                <label for="bp-zoom-meeting-recording-cloud"><span><?php _e( 'In the cloud', 'buddyboss-pro' ); ?></span></label>
                            </div>
                        <?php else: ?>
                            <div class="bb-field-wrap checkbox-row">
                                <input type="checkbox" id="bp-zoom-meeting-auto-recording" value="yes" name="bp-zoom-meeting-auto-recording" class="bs-styled-checkbox"/>
                                <label for="bp-zoom-meeting-auto-recording"><span><?php _e( 'Record automatically onto local computer', 'buddyboss-pro' ); ?></span></label>
                            </div>
                        <?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<hr />

		<div class="bb-field-wrapper-inner">
            <div class="bb-field-wrap full-row">
                <label for="bp-zoom-meeting-host"><?php _e( 'Host', 'buddyboss-pro' ); ?></label>
				<div class="bb-meeting-input-wrap">
					<input type="text" id="bp-zoom-meeting-host" value="<?php echo bp_zoom_groups_api_host_show( $group_id ); ?>" name="bp-zoom-meeting-host" disabled />
					<p class="description"><?php _e( 'Default host for all meetings in this group.', 'buddyboss-pro' ); ?></p>
				</div>
            </div>
            <?php if ( ! $disable_alt_host ) : ?>
                <div class="bb-field-wrap full-row bp-zoom-meeting-alt-host">
                    <label for="bp-zoom-meeting-alt-host-ids"><?php _e( 'Alternative Hosts', 'buddyboss-pro' ); ?></label>
                    <div class="bb-meeting-host-select-wrap bb-meeting-input-wrap">
                        <input type="text" placeholder="<?php _e( 'Example: mary@company.com, peter@school.edu', 'buddyboss-pro' ); ?>" id="bp-zoom-meeting-alt-host-ids" name="bp-zoom-meeting-alt-host-ids" value="<?php echo $default_group_host_email !== $current_user_data->user_email ? $current_user_data->user_email : ''; ?>" />
                        <p class="description"><?php _e( 'Additional hosts for this meeting, entered by email, comma separated. Each email added needs to match with a user in the default host\'s Zoom account.', 'buddyboss-pro' ); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

	<hr />

    <footer class="bb-model-footer text-right">
	    <?php
	    wp_nonce_field( 'bp_zoom_meeting' );
	    if ( ! empty( $group_id ) ) { ?>
			<input type="hidden" id="bp-zoom-meeting-group-id" name="bp-zoom-meeting-group-id" value="<?php echo $group_id; ?>"/>
		<?php } ?>
		<input type="hidden" name="action" value="zoom_meeting_add" />
        <a class="button submit" id="bp-zoom-meeting-form-submit" href="#"><?php _e( 'Create Meeting', 'buddyboss-pro' ); ?></a>
    </footer>
</div>
