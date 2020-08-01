<?php
/**
 * BuddyBoss - Groups Create Zoom Meetings
 *
 * @since 1.0.0
 */

$disable_registration = false;
$disable_recording    = false;
$disable_alt_host     = false;
$host_type            = groups_get_groupmeta( bp_get_zoom_meeting_group_id(), 'bp-group-zoom-api-host-type', true );
if ( 1 === (int) $host_type ) {
	$disable_registration = true;
	$disable_recording    = true;
	$disable_alt_host     = true;
}
?>

<div class="bb-title-wrap">
	<h2 class="bb-title"><?php _e( 'Edit Meeting', 'buddyboss-pro' ); ?></h2>
	<!--<a href="#" class="bp-close-create-meeting-form"><span class="bb-icon-x"></span></a>-->
</div>

<div class="bp-meeting-fields-wrap">
	<div class="bb-field-wrapper">
		<div class="bb-field-wrapper-inner">
			<div class="bb-field-wrap">
				<label for="bp-zoom-meeting-title"><?php _e( 'Meeting Title', 'buddyboss-pro' ); ?>*</label>
				<div class="bb-meeting-input-wrap">
					<input autocomplete="off" type="text" id="bp-zoom-meeting-title" value="<?php bp_zoom_meeting_title(); ?>" name="bp-zoom-meeting-title" />
				</div>
			</div>

			<div class="bb-field-wrap">
                <label for="bp-zoom-meeting-description"><?php _e( 'Description (optional)', 'buddyboss-pro' ); ?></label>
				<div class="bb-meeting-input-wrap">
					<textarea id="bp-zoom-meeting-description" name="bp-zoom-meeting-description"><?php bp_zoom_meeting_description(); ?></textarea>
				</div>
            </div>

			<div class="bb-field-wrap">
				<label for="bp-zoom-meeting-password"><?php _e( 'Password (optional)', 'buddyboss-pro' ); ?></label>
				<div class="bb-meeting-input-wrap bp-toggle-meeting-password-wrap">
					<a href="#" class="bp-toggle-meeting-password"><i class="bb-icon-eye"></i><i class="bb-icon-eye-off"></i></a>
					<input autocomplete="new-password" type="password" id="bp-zoom-meeting-password" value="<?php bp_zoom_meeting_password(); ?>" name="bp-zoom-meeting-password"/>
				</div>
			</div>
		</div>

		<hr />

		<div class="bb-field-wrapper-inner">

			<div class="bb-field-wrap">
				<label for="bp-zoom-meeting-start-date"><?php _e( 'When', 'buddyboss-pro' ); ?>*</label>
				<?php
				$start_date_time     = bp_get_zoom_meeting_start_date();
				$start_date          = gmdate( 'Y-m-d', strtotime( $start_date_time ) );
				$start_time          = gmdate( 'h:i', strtotime( $start_date_time ) );
				$start_time_meridian = gmdate( 'A', strtotime( $start_date_time ) );

				if ( empty( $start_time ) ) {
					$start_time = '00:00';
				} else {
					$explode_start_time = explode( ':', $start_time );
					if ( ! isset( $explode_start_time[0] ) || empty( $explode_start_time[0] ) || '12' === $explode_start_time[0] ) {
						$explode_start_time[0] = '00';
					}
					$start_time = implode( ':', $explode_start_time );
				}
				?>
				<div class="bp-wrap-duration bb-meeting-input-wrap">
					<div class="bb-field-wrap start-date-picker">
						<input type="text" id="bp-zoom-meeting-start-date" value="<?php echo esc_attr( $start_date ); ?>" name="bp-zoom-meeting-start-date" placeholder="yyyy-mm-dd" autocomplete="off"/>
					</div>
					<div class="bb-field-wrap start-time-picker">
						<input type="text" id="bp-zoom-meeting-start-time" value="<?php echo esc_attr( $start_time ); ?>" name="bp-zoom-meeting-start-time" placeholder="hh:mm" autocomplete="off" />
					</div>
					<div class="bb-field-wrap bp-zoom-meeting-time-meridian-wrap">
						<label for="bp-zoom-meeting-start-time-meridian-am">
							<input type="radio" value="am" id="bp-zoom-meeting-start-time-meridian-am" name="bp-zoom-meeting-start-time-meridian" <?php checked( 'AM', $start_time_meridian ); ?>>
							<span class="bb-time-meridian"><?php _e( 'AM', 'buddyboss-pro' ); ?></span>
						</label>
						<label for="bp-zoom-meeting-start-time-meridian-pm">
							<input type="radio" value="pm" id="bp-zoom-meeting-start-time-meridian-pm" name="bp-zoom-meeting-start-time-meridian" <?php checked( 'PM', $start_time_meridian ); ?>>
							<span class="bb-time-meridian"><?php _e( 'PM', 'buddyboss-pro' ); ?></span>
						</label>
					</div>
				</div>
			</div>

			<div class="bb-field-wrap">
				<?php
				$duration = bp_get_zoom_meeting_duration();
				$hours    = ( ( 0 !== $duration ) ? floor( $duration / 60 ) : 0 );
				$minutes  = ( ( 0 !== $duration ) ? ( $duration % 60 ) : 0 );
				?>
				<label for="bp-zoom-meeting-duration"><?php _e( 'Duration', 'buddyboss-pro' ); ?>*</label>
				<div class="bp-wrap-duration">
					<div class="bb-field-wrap">
						<select id="bp-zoom-meeting-duration-hr" name="bp-zoom-meeting-duration-hr">
							<?php
							for ( $hr = 0; $hr <= 24; $hr ++ ) {
								echo '<option value="' . esc_attr( $hr ) . '" ' . selected( $hours, $hr, false ) . '>' . esc_attr( $hr ) . '</option>';
							}
							?>
						</select>
						<label for="bp-zoom-meeting-duration-hr"><?php _e( 'hr', 'buddyboss-pro' ); ?></label>
					</div>
					<div class="bb-field-wrap">
						<select id="bp-zoom-meeting-duration-min" name="bp-zoom-meeting-duration-min">
							<?php
							$min = 0;
							while ( $min <= 45 ) {
								echo '<option value="' . esc_attr( $min ) . '" ' . selected( $minutes, $min, false ) . '>' . esc_attr( $min ) . '</option>';
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
					<?php $timezones = bp_zoom_get_timezone_options(); ?>
					<?php foreach ( $timezones as $k => $timezone ) { ?>
						<option value="<?php echo $k; ?>" <?php echo bp_get_zoom_meeting_timezone() === $k ? 'selected' : ''; ?>><?php echo $timezone; ?></option>
					<?php } ?>
				</select>
				</div>
			</div>
		</div>

		<hr />

		<div class="bb-field-wrapper-inner">
			<div class="bb-field-wrap">
				<label class="bb-video-label"><?php _e( 'Video', 'buddyboss-pro' ); ?></label>
				<div class="bb-video-fields-wrap">
					<div class="bb-field-wrap checkbox-row">
						<label for="bp-zoom-meeting-host-video">
							<span class="label-span"><?php _e( 'Host', 'buddyboss-pro' ); ?></span>
							<div class="bb-toggle-switch">
								<input type="checkbox" id="bp-zoom-meeting-host-video" value="yes" name="bp-zoom-meeting-host-video" class="bs-styled-checkbox" <?php checked( 1, bp_get_zoom_meeting_host_video() ); ?>/>
								<span class="bb-toggle-slider"></span>
							</div>
						</label>
					</div>

					<div class="bb-field-wrap checkbox-row">
						<label for="bp-zoom-meeting-participants-video">
							<span class="label-span"><?php _e( 'Participants', 'buddyboss-pro' ); ?></span>
							<div class="bb-toggle-switch">
								<input type="checkbox" id="bp-zoom-meeting-participants-video" value="yes" name="bp-zoom-meeting-participants-video" class="bs-styled-checkbox" <?php checked( 1, bp_get_zoom_meeting_participants_video() ); ?>/>
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
				<div class="bb-meeting-options-wrap">
					<?php if ( ! $disable_registration ) : ?>
                        <div class="bb-field-wrap checkbox-row">
                            <input type="checkbox" name="bp-zoom-meeting-registration" id="bp-zoom-meeting-registration" value="yes" class="bs-styled-checkbox" <?php checked( 1, ! empty( bp_get_zoom_meeting_registration_url() ) ); ?>/>
                            <label for="bp-zoom-meeting-registration"><span><?php _e( 'Require Registration', 'buddyboss-pro' ); ?></span></label>
                        </div>
					<?php endif; ?>

					<div class="bb-field-wrap checkbox-row">
						<input type="checkbox" id="bp-zoom-meeting-join-before-host" value="yes" name="bp-zoom-meeting-join-before-host" class="bs-styled-checkbox" <?php checked( 1, bp_get_zoom_meeting_join_before_host() ); ?> />
						<label for="bp-zoom-meeting-join-before-host"><span><?php _e( 'Enable join before host', 'buddyboss-pro' ); ?></span></label>
					</div>

					<div class="bb-field-wrap checkbox-row">
						<input type="checkbox" id="bp-zoom-meeting-mute-participants" value="yes" name="bp-zoom-meeting-mute-participants" class="bs-styled-checkbox" <?php checked( 1, bp_get_zoom_meeting_mute_participants() ); ?> />
						<label for="bp-zoom-meeting-mute-participants"><span><?php _e( 'Mute participants upon entry', 'buddyboss-pro' ); ?></span></label>
					</div>

					<div class="bb-field-wrap checkbox-row">
						<input type="checkbox" id="bp-zoom-meeting-waiting-room" value="yes" name="bp-zoom-meeting-waiting-room" class="bs-styled-checkbox" <?php checked( 1, bp_get_zoom_meeting_waiting_room() ); ?> />
						<label for="bp-zoom-meeting-waiting-room"><span><?php _e( 'Enable waiting room', 'buddyboss-pro' ); ?></span></label>
					</div>

					<div class="bb-field-wrap checkbox-row">
						<input type="checkbox" id="bp-zoom-meeting-authentication" value="yes" name="bp-zoom-meeting-authentication" class="bs-styled-checkbox" <?php checked( 1, bp_get_zoom_meeting_authentication() ); ?> />
						<label for="bp-zoom-meeting-authentication"><span><?php _e( 'Only authenticated users can join', 'buddyboss-pro' ); ?></span></label>
					</div>

					<div class="bb-field-wrap full-row">
                        <?php if ( ! $disable_recording ) : ?>
                            <input type="checkbox" id="bp-zoom-meeting-auto-recording" value="yes" name="bp-zoom-meeting-auto-recording" class="bs-styled-checkbox" <?php echo in_array( bp_get_zoom_meeting_auto_recording(), array(
                                'local',
                                'cloud'
                            ) ) ? 'checked' : ''; ?> />
                            <label for="bp-zoom-meeting-auto-recording"><span><?php _e( 'Record the meeting automatically', 'buddyboss-pro' ); ?></span></label>

                            <div class="bp-zoom-meeting-auto-recording-options <?php echo in_array( bp_get_zoom_meeting_auto_recording(), array(
                                'local',
                                'cloud'
                            ) ) ? '' : 'bp-hide'; ?>">
                                <input type="radio" value="local" id="bp-zoom-meeting-recording-local" name="bp-zoom-meeting-recording" class="bs-styled-radio" <?php checked( 'local', bp_get_zoom_meeting_auto_recording() ); ?> />
                                <label for="bp-zoom-meeting-recording-local"><span><?php _e( 'On the local computer', 'buddyboss-pro' ); ?></span></label>
                                <input type="radio" value="cloud" id="bp-zoom-meeting-recording-cloud" name="bp-zoom-meeting-recording" class="bs-styled-radio" <?php checked( 'cloud', bp_get_zoom_meeting_auto_recording() ); ?>/>
                                <label for="bp-zoom-meeting-recording-cloud"><span><?php _e( 'In the cloud', 'buddyboss-pro' ); ?></span></label>
                            </div>
                        <?php else: ?>
                            <div class="bb-field-wrap checkbox-row">
                                <input type="checkbox" id="bp-zoom-meeting-auto-recording" value="yes" name="bp-zoom-meeting-auto-recording" class="bs-styled-checkbox" <?php checked( 'local', bp_get_zoom_meeting_auto_recording() ); ?>/>
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
					<input type="text" id="bp-zoom-meeting-host" value="<?php echo bp_zoom_api_host_show(); ?>" name="bp-zoom-meeting-host" disabled />
					<p class="description"><?php _e( 'Default host for all meetings in this group.', 'buddyboss-pro' ); ?></p>
				</div>
            </div>

			<?php if ( ! $disable_alt_host ) : ?>
                <div class="bb-field-wrap full-row bp-zoom-meeting-alt-host">
                    <label for="bp-zoom-meeting-alt-host-ids"><?php _e( 'Alternative Hosts', 'buddyboss-pro' ); ?></label>
                    <div class="bb-meeting-host-select-wrap bb-meeting-input-wrap">
                        <input type="text" placeholder="<?php _e( 'Example: mary@company.com, peter@school.edu', 'buddyboss-pro' ); ?>" id="bp-zoom-meeting-alt-host-ids" name="bp-zoom-meeting-alt-host-ids" value="<?php echo bp_get_zoom_meeting_alternative_host_ids(); ?>" />
                        <p class="description"><?php _e( 'Additional hosts for this meeting, entered by email, comma separated. Each email added needs to match with a user in the default host\'s Zoom account.', 'buddyboss-pro' ); ?></p>
                    </div>
                </div>
			<?php endif; ?>
		</div>

	</div>

	<hr />

	<footer class="bb-model-footer meeting-item text-right" data-id="<?php bp_zoom_meeting_id(); ?>">
		<?php wp_nonce_field( 'bp_zoom_meeting' ); ?>
		<input type="hidden" name="action" value="zoom_meeting_add"/>
		<input type="hidden" id="bp-zoom-meeting-id" name="bp-zoom-meeting-id" value="<?php bp_zoom_meeting_id(); ?>"/>
		<input type="hidden" id="bp-zoom-meeting-zoom-id" name="bp-zoom-meeting-zoom-id" value="<?php bp_zoom_meeting_zoom_meeting_id(); ?>"/>
		<input type="hidden" id="bp-zoom-meeting-group-id" name="bp-zoom-meeting-group-id" value="<?php bp_zoom_meeting_group_id(); ?>"/>
		<a href="#" id="bp-zoom-meeting-cancel-edit" class="text-button small"><?php _e( 'Cancel', 'buddyboss-pro' ); ?></a>
		<a id="bp-zoom-meeting-form-submit" name="bp-zoom-meeting-form-submit" class="button submit"><?php _e( 'Update Meeting', 'buddyboss-pro' ); ?></a>
	</footer>
</div>
