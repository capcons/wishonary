import {__} from '@wordpress/i18n';
import {InspectorControls} from '@wordpress/block-editor';
import {registerBlockType} from '@wordpress/blocks';
import {__experimentalGetSettings, dateI18n} from '@wordpress/date';
import {
    TextControl,
    TextareaControl,
    PanelBody,
    Popover,
    DateTimePicker,
    DatePicker,
    Button,
    __experimentalText as Text,
    SelectControl,
    CheckboxControl,
    Placeholder,
    BaseControl
} from '@wordpress/components';
import {useState} from '@wordpress/element';

/**
 * Returns whether buddyboss category is in editor cats list or not
 *
 * @return {boolean} true if category is in list.
 */
export const isBuddyBossInCategories = () => {
    const blockCategories = wp.blocks.getCategories();
    for (var i in blockCategories) {
        if ('buddyboss' === blockCategories[i].slug) {
            return true;
        }
    }
    return false;
};

const currentDateTime = new Date( bpZoomMeetingBlock.wp_date_time );
currentDateTime.setMinutes( currentDateTime.getMinutes() + ( 60 - currentDateTime.getMinutes() ) );

registerBlockType('bp-zoom-meeting/create-meeting', {
    title: __('Zoom Meeting', 'buddyboss-pro'),
    description: __('Create meeting in Zoom', 'buddyboss-pro'),
    icon: 'video-alt2',
    category: isBuddyBossInCategories() ? 'buddyboss' : 'common',

    attributes: {
        id: {
            type: 'number',
            default: ''
        },
        meetingId: {
            type: 'number',
            default: ''
        },
        hostId: {
            type: 'string',
            default: typeof bpZoomMeetingBlock.default_host_id !== 'undefined' ? bpZoomMeetingBlock.default_host_id : ''
        },
        hostDisplayName: {
            type: 'string',
            default: typeof bpZoomMeetingBlock.default_host_user !== 'undefined' ? bpZoomMeetingBlock.default_host_user : ''
        },
        alt_hosts : {
          type: 'string',
          default: ''
        },
        title: {
            type: 'string',
            default: ''
        },
        description: {
            type: 'string',
            default: ''
        },
        startDate: {
            type: 'string',
            default: dateI18n('Y-m-d H:i:s', currentDateTime)
        },
        duration: {
            type: 'string',
            default: '30'
        },
        timezone: {
            type: 'string',
            default: typeof bpZoomMeetingBlock.wp_timezone !== 'undefined' ? bpZoomMeetingBlock.wp_timezone : ''
        },
        password: {
            type: 'string',
            default: ''
        },
        registration: {
            type: 'boolean',
            default: false
        },
        hostVideo: {
            type: 'boolean',
            default: false
        },
        participantsVideo: {
            type: 'boolean',
            default: false
        },
        joinBeforeHost: {
            type: 'boolean',
            default: false
        },
        muteParticipants: {
            type: 'boolean',
            default: false
        },
        waitingRoom: {
            type: 'boolean',
            default: false
        },
        authentication: {
            type: 'boolean',
            default: false
        },
        autoRecording: {
            type: 'string',
            default: 'none'
        },
        meetingFormType: {
            type: 'string',
            default: ''
        },
        external_meeting: {
            type: 'boolean',
            default: false
        }
    },

    edit: (props) => {
        const {setAttributes} = props;
        const host_user_type = typeof bpZoomMeetingBlock.default_host_user_type !== 'undefined' ? bpZoomMeetingBlock.default_host_user_type : 1;
        const {
            meetingId,
            hostId,
            hostDisplayName,
            title,
            description,
            startDate,
            duration,
            timezone,
            password,
            registration,
            hostVideo,
            participantsVideo,
            joinBeforeHost,
            muteParticipants,
            waitingRoom,
            authentication,
            autoRecording,
            meetingFormType,
            alt_hosts,
            external_meeting
        } = props.attributes;

        const setMeetingId = (val) => {
            val = val.toString().replace(/\s/g, '');
            setAttributes({meetingId: parseInt(val)});
        }
        const setHostId = (val) => {
            setAttributes({hostId: val});
        }
        const setHostDisplayName = (val) => {
            setAttributes({hostDisplayName: val});
        }
        const setTitle = (val) => {
            setAttributes({title: val});
        }
        const setDescription = (val) => {
            setAttributes({description: val});
        }
        const setStartDate = (val) => {
            let nowDate = new Date( bpZoomMeetingBlock.wp_date_time );
            let selectedDate = new Date(val);
            if ( nowDate.getTime() < selectedDate.getTime() ) {
                setAttributes({startDate: val});
            }
        }
        const setDuration = (val) => {
            setAttributes({duration: val});
        }
        const setTimezone = (val) => {
            setAttributes({timezone: val});
        }
        const setPassword = (val) => {
            setAttributes({password: val});
        }
        const setRegistration = (val) => {
            setAttributes({registration: val});
        }
        const setHostVideo = (val) => {
            setAttributes({hostVideo: val});
        }
        const setParticipantsVideo = (val) => {
            setAttributes({participantsVideo: val});
        }
        const setJoinBeforeHost = (val) => {
            setAttributes({joinBeforeHost: val});
        }
        const setMuteParticipants = (val) => {
            setAttributes({muteParticipants: val});
        }
        const setWaitingRoom = (val) => {
            setAttributes({waitingRoom: val});
        }
        const setAuthentication = (val) => {
            setAttributes({authentication: val});
        }
        const setAutoRecording = (val) => {
            setAttributes({autoRecording: val});
        }
        const setMeetingFormType = (val) => {
            setAttributes({meetingFormType: val});
        }

        const setAltHosts = (val) => {
            setAttributes({alt_hosts: val});
        }
        const setExternalMeeting = (val) => {
            setAttributes({external_meeting: val});
        }
        const settings = __experimentalGetSettings();
        const [isPickerOpen, setIsPickerOpen] = useState(false);
        const resolvedFormat = settings.formats.datetime || 'Y-m-d H:i:s';
        let auto_recording_options = [];

        if ( host_user_type == 2 ) {
            auto_recording_options = [
                {label: __('No Recordings', 'buddyboss-pro'), value: 'none'},
                {label: __('Cloud', 'buddyboss-pro'), value: 'cloud'},
                {label: __('Local', 'buddyboss-pro'), value: 'local'},
            ];
        } else {
            auto_recording_options = [
                {label: __('No Recordings', 'buddyboss-pro'), value: 'none'},
                {label: __('Local', 'buddyboss-pro'), value: 'local'},
            ];
        }

        return (
            <>
                {'' === meetingFormType ?
                    <Placeholder
                        icon="video-alt2"
                        className="bb-input-container"
                        label={__('Zoom Meeting', 'buddyboss-pro')}
                        instructions={__('Create meeting or add existing meeting.', 'buddyboss-pro')}
                        >

                        <Button isSecondary onClick={() => {
                            setMeetingFormType('create')
                        }}>
                            {__('Create Meeting', 'buddyboss-pro')}
                        </Button>
                        <Button isSecondary onClick={() => {
                            setMeetingFormType('existing')
                        }}>
                            {__('Add Existing Meeting', 'buddyboss-pro')}
                        </Button>
                    </Placeholder>
                    : ''
                }
                {'existing' === meetingFormType ?
                    <>
                        <Placeholder icon="video-alt2" className="bb-meeting-id-input-container" label={__('Add Existing Meeting', 'buddyboss-pro')}>
                            <TextControl
                                label={__('Meeting ID', 'buddyboss-pro')}
                                value={meetingId}
                                className="components-placeholder__input bb-meeting-id-wrap"
                                placeholder={__('Enter meeting ID without spaces…', 'buddyboss-pro')}
                                onChange={setMeetingId}
                            />
                            <BaseControl
                                className="bb-buttons-wrap"
                            >
                            <Button isPrimary onClick={(e) => {
                                var target = e.target;
                                target.setAttribute('disabled', true);
                                const meeting_data = {
                                    '_wpnonce': bpZoomMeetingBlock.bp_zoom_meeting_nonce,
                                    'bp-zoom-meeting-id': meetingId,
                                };

                                wp.ajax.send('zoom_meeting_update_in_site', {
                                    data: meeting_data,
                                    success: function (response) {
                                        target.removeAttribute('disabled');
                                        if (typeof response.meeting !== 'undefined' && response.meeting.type == 8) {
                                            wp.data.dispatch('core/notices').createNotice(
                                                'error',
                                                __('This is a recurring Zoom meeting, which we do not yet support. Please enter a different meeting ID.', 'buddyboss-pro'), // Text string to display.
                                                {
                                                    isDismissible: true, // Whether the user can dismiss the notice.
                                                }
                                            );
                                            return false;
                                        }
                                        wp.data.dispatch('core/notices').createNotice(
                                            'success', // Can be one of: success, info, warning, error.
                                            __('Meeting Updated.', 'buddyboss-pro'), // Text string to display.
                                            {
                                                isDismissible: true, // Whether the user can dismiss the notice.
                                            }
                                        );
                                        if (typeof response.host_name !== 'undefined') {
                                            setHostDisplayName(response.host_name);
                                        }
                                        if (typeof response.host_email !== 'undefined') {
                                            setHostId(response.host_email);
                                        }
                                        if (typeof response.meeting !== 'undefined') {
                                            if (typeof response.meeting.id !== 'undefined') {
                                                setMeetingId(response.meeting.id);
                                            }
                                            if (typeof response.meeting.host_id !== 'undefined') {
                                                setHostId(response.meeting.host_id);
                                            }
                                            if (typeof response.meeting.topic !== 'undefined') {
                                                setTitle(response.meeting.topic);
                                            }
                                            if (typeof response.meeting.agenda !== 'undefined') {
                                                setDescription(response.meeting.agenda);
                                            }
                                            if (typeof response.meeting.timezone !== 'undefined') {
                                                setTimezone(response.meeting.timezone);
                                            }
                                            if (typeof response.meeting.start_time !== 'undefined') {
                                                setAttributes({startDate: response.meeting.start_time});
                                            }
                                            if (typeof response.meeting.duration !== 'undefined') {
                                                setDuration(response.meeting.duration);
                                            }
                                            if (typeof response.meeting.password !== 'undefined') {
                                                setPassword(response.meeting.password);
                                            }
                                            if (typeof response.meeting.settings !== 'undefined') {
                                                if (typeof response.meeting.settings.alternative_hosts !== 'undefined') {
                                                    setAltHosts(response.meeting.settings.alternative_hosts);
                                                }
                                                if (typeof response.meeting.settings.approval_type !== 'undefined' && 0 == response.meeting.settings.approval_type) {
                                                    setRegistration(true);
                                                }
                                                if (typeof response.meeting.settings.host_video !== 'undefined') {
                                                    setHostVideo(response.meeting.settings.host_video);
                                                }
                                                if (typeof response.meeting.settings.participants_video !== 'undefined') {
                                                    setParticipantsVideo(response.meeting.settings.participants_video);
                                                }
                                                if (typeof response.meeting.settings.join_before_host !== 'undefined') {
                                                    setJoinBeforeHost(response.meeting.settings.join_before_host);
                                                }
                                                if (typeof response.meeting.settings.mute_participants !== 'undefined') {
                                                    setMuteParticipants(response.meeting.settings.mute_participants);
                                                }
                                                if (typeof response.meeting.settings.waiting_room !== 'undefined') {
                                                    setWaitingRoom(response.meeting.settings.waiting_room);
                                                }
                                                if (typeof response.meeting.settings.meeting_authentication !== 'undefined') {
                                                    setAuthentication(response.meeting.settings.meeting_authentication);
                                                }
                                                if (typeof response.meeting.settings.auto_recording !== 'undefined') {
                                                    setAutoRecording(response.meeting.settings.auto_recording);
                                                }
                                            }
                                        }
                                        setMeetingFormType('create');
                                        setExternalMeeting(true);
                                        var editorInfo = wp.data.select('core/editor');
                                        if (editorInfo.isEditedPostSaveable()) {
                                            if (!editorInfo.isCurrentPostPublished() && ~['draft', 'auto-draft'].indexOf(editorInfo.getEditedPostAttribute('status'))) {
                                                // for some reason if post is draft we must update manually  post status
                                                // otherwise post will be saved but not published;
                                                wp.data.dispatch('core/editor').autosave();
                                                // wp.data.dispatch('core/editor').editPost({status: 'publish'});
                                            } else {
                                                wp.data.dispatch('core/editor').savePost();
                                            }
                                        }
                                    },
                                    error: function (error) {
                                        target.removeAttribute('disabled');
                                        wp.data.dispatch('core/notices').createNotice(
                                            'error', // Can be one of: success, info, warning, error.
                                            error.error, // Text string to display.
                                            {
                                                isDismissible: true, // Whether the user can dismiss the notice.
                                            }
                                        );
                                    }
                                });
                            }}>
                                {__('Save', 'buddyboss-pro')}
                            </Button>
                            {meetingId < 1 || '' === meetingId ?
                                <Button isTertiary onClick={() => {
                                    setMeetingFormType('')
                                }}>
                                    {__('Cancel', 'buddyboss-pro')}
                                </Button>
                                :
                                ''
                            }
                            </BaseControl>
                        </Placeholder>

                    </>
                    :
                    ''
                }
                {'create' === meetingFormType ?
                    <>
                        <Placeholder icon="video-alt2" label={
                            !external_meeting ?
                                __('Create Meeting', 'buddyboss-pro')
                                :
                                __('Existing Meeting', 'buddyboss-pro')
                        }
                                     className="bp-meeting-block-create">
                            <TextControl
                                label=''
                                type="hidden"
                                value={meetingId}
                            />
                            <TextControl
                                label={__('Title', 'buddyboss-pro')}
                                value={title}
                                onChange={setTitle}
                            />
                            <BaseControl
                                label={__('When', 'buddyboss-pro')}
                                className="bb-meeting-time-wrap"
                            >
                                <time dateTime={dateI18n('c', startDate)}>
                                    <Button
                                        icon="edit"
                                        isTertiary
                                        isLink
                                        onClick={() =>
                                            setIsPickerOpen(
                                                (_isPickerOpen) => !_isPickerOpen
                                            )
                                        }>
                                        {dateI18n(resolvedFormat, startDate)}
                                    </Button>
                                    {isPickerOpen && (
                                        <Popover onClose={setIsPickerOpen.bind(null, false)}>
                                            <DateTimePicker
                                                currentDate={startDate}
                                                onChange={setStartDate}
                                                is12Hour={true}
                                            />
                                        </Popover>
                                    )}
                                </time>
                            </BaseControl>
                            <SelectControl
                                label={__('Timezone', 'buddyboss-pro')}
                                value={timezone}
                                options={bpZoomMeetingBlock.timezones}
                                onChange={setTimezone}
                            />
                            <SelectControl
                                label={__('Auto Recording', 'buddyboss-pro')}
                                value={autoRecording}
                                options={auto_recording_options}
                                onChange={setAutoRecording}
                            />
                            <BaseControl className="bb-buttons-wrap">
                            <Button
                                className="submit-meeting"
                                isPrimary
                                onClick={(e) => {
                                    const target = e.target;
                                    target.setAttribute('disabled', true);
                                    const meeting_data = {
                                        '_wpnonce': bpZoomMeetingBlock.bp_zoom_meeting_nonce,
                                        'bp-zoom-meeting-zoom-id': meetingId,
                                        'bp-zoom-meeting-start-date': startDate,
                                        'bp-zoom-meeting-timezone': timezone,
                                        'bp-zoom-meeting-duration': duration,
                                        'bp-zoom-meeting-password': password,
                                        'bp-zoom-meeting-recording': autoRecording,
                                        'bp-zoom-meeting-alt-host-ids': alt_hosts,
                                        'bp-zoom-meeting-title': title,
                                        'bp-zoom-meeting-description': description,
                                    };

                                    meeting_data['bp-zoom-meeting-type'] = 2;

                                    if (registration) {
                                        meeting_data['bp-zoom-meeting-registration'] = 1;
                                    }

                                    if (joinBeforeHost) {
                                        meeting_data['bp-zoom-meeting-join-before-host'] = 1;
                                    }

                                    if (hostVideo) {
                                        meeting_data['bp-zoom-meeting-host-video'] = 1;
                                    }

                                    if (participantsVideo) {
                                        meeting_data['bp-zoom-meeting-participants-video'] = 1;
                                    }

                                    if (muteParticipants) {
                                        meeting_data['bp-zoom-meeting-mute-participants'] = 1;
                                    }

                                    if (waitingRoom) {
                                        meeting_data['bp-zoom-meeting-waiting-room'] = 1;
                                    }

                                    if (authentication) {
                                        meeting_data['bp-zoom-meeting-authentication'] = 1;
                                    }

                                    wp.ajax.send('zoom_meeting_block_add', {
                                        data: meeting_data,
                                        success: function (response) {
                                            var editorInfo = wp.data.select('core/editor');
                                            if (response.meeting.id) {
                                                setMeetingId(response.meeting.id);
                                            }
                                            target.removeAttribute('disabled');
                                            wp.data.dispatch('core/notices').createNotice(
                                                'success', // Can be one of: success, info, warning, error.
                                                __('Meeting Updated.', 'buddyboss-pro'), // Text string to display.
                                                {
                                                    isDismissible: true, // Whether the user can dismiss the notice.
                                                }
                                            );
                                            setMeetingFormType('create');
                                            // save post if is ok to save
                                            if (editorInfo.isEditedPostSaveable()) {
                                                if (!editorInfo.isCurrentPostPublished() && ~['draft', 'auto-draft'].indexOf(editorInfo.getEditedPostAttribute('status'))) {
                                                    wp.data.dispatch('core/editor').autosave();
                                                } else {
                                                    wp.data.dispatch('core/editor').savePost();
                                                }
                                            }
                                        },
                                        error: function (error) {
                                            target.removeAttribute('disabled');
                                            if ( typeof error.errors !== 'undefined' ) {
                                                for( let er in error.errors ) {
                                                    wp.data.dispatch('core/notices').createNotice(
                                                        'error',
                                                        error.errors[er].message, // Text string to display.
                                                        {
                                                            isDismissible: true, // Whether the user can dismiss the notice.
                                                        }
                                                    );
                                                }
                                            } else {
                                                wp.data.dispatch('core/notices').createNotice(
                                                    'error', // Can be one of: success, info, warning, error.
                                                    error.error, // Text string to display.
                                                    {
                                                        isDismissible: true, // Whether the user can dismiss the notice.
                                                    }
                                                );
                                            }
                                        }
                                    });
                                }
                                }>
                                {__('Save Meeting', 'buddyboss-pro')}
                            </Button>
                            {meetingId < 1 || '' === meetingId ?
                                <Button isTertiary onClick={() => {
                                    setMeetingFormType('')
                                }}>
                                    {__('Cancel', 'buddyboss-pro')}
                                </Button>
                                :
                                ''
                            }
                            </BaseControl>
                        </Placeholder>
                    </>
                    :
                    ''
                }
                {'create' === meetingFormType ?
                    <InspectorControls>
                        <PanelBody
                            title={__('Settings', 'buddyboss-pro')}
                            initialOpen={true}>
                            <TextareaControl
                                label={__('Description (optional)', 'buddyboss-pro')}
                                value={description}
                                onChange={setDescription}
                            />
                            <TextControl
                                label={__('Password (optional)', 'buddyboss-pro')}
                                onChange={setPassword}
                                value={password}
                            />
                            <TextControl
                                type="number"
                                label={__('Duration (minutes)', 'buddyboss-pro')}
                                onChange={setDuration}
                                value={duration}
                            />
                            <TextControl
                                label={__('Default Host', 'buddyboss-pro')}
                                type="text"
                                disabled
                                value={hostDisplayName}
                            />
                            {
                                host_user_type == 2
                                ?
                                    <TextControl
                                        label={__('Alternative Hosts', 'buddyboss-pro')}
                                        onChange={setAltHosts}
                                        value={alt_hosts}
                                        placeholder={__('Example: mary@company.com','buddyboss-pro')}
                                        help={__('Entered by email, comma separated. Each email added needs to match with a user in your Zoom account.','buddyboss-pro')}
                                    />
                                    :
                                    ''
                            }
                            <CheckboxControl
                                label={__('Start video when host joins', 'buddyboss-pro')}
                                checked={hostVideo}
                                onChange={setHostVideo}
                                className="bb-checkbox-wrap"
                            />
                            <CheckboxControl
                                label={__('Start video when participants join', 'buddyboss-pro')}
                                checked={participantsVideo}
                                onChange={setParticipantsVideo}
                                className="bb-checkbox-wrap"
                            />
                            {
                                host_user_type == 2
                                    ?
                                    <CheckboxControl
                                        label={__('Require Registration', 'buddyboss-pro')}
                                        checked={registration}
                                        onChange={setRegistration}
                                        className="bb-checkbox-wrap"
                                    />
                                    :
                                    ''
                            }
                            <CheckboxControl
                                label={__('Enable join before host', 'buddyboss-pro')}
                                checked={joinBeforeHost}
                                onChange={setJoinBeforeHost}
                                className="bb-checkbox-wrap"
                            />
                            <CheckboxControl
                                label={__('Mute participants upon entry', 'buddyboss-pro')}
                                checked={muteParticipants}
                                onChange={setMuteParticipants}
                                className="bb-checkbox-wrap"
                            />
                            <CheckboxControl
                                label={__('Enable waiting room', 'buddyboss-pro')}
                                checked={waitingRoom}
                                onChange={setWaitingRoom}
                                className="bb-checkbox-wrap"
                            />
                            <CheckboxControl
                                label={__('Only authenticated users can join', 'buddyboss-pro')}
                                checked={authentication}
                                onChange={setAuthentication}
                                className="bb-checkbox-wrap"
                            />
                        </PanelBody>
                    </InspectorControls>
                    :
                    ''
                }
            </>
        );
    },
});

/**
 * Get meeting blocks in current editor
 *
 * @return {[]} Array of meeting blocks
 */
export const getMeetingBlocks = () => {
    const editorBlocks = wp.data.select( 'core/block-editor' ).getBlocks(),
        meetingBlocks = [];
    let i = 0;

    for ( i in editorBlocks ) {
        if ( editorBlocks[ i ].isValid && editorBlocks[ i ].name === 'bp-zoom-meeting/create-meeting' ) {
            meetingBlocks.push( editorBlocks[ i ] );
        }
    }
    return meetingBlocks;
};

wp.domReady(function(){
    var postSaveButtonClasses = '.editor-post-publish-button';
    jQuery(document).on('click', postSaveButtonClasses , function(e){
        e.stopPropagation();
        e.preventDefault();
        let meetingBlocks = getMeetingBlocks();
        if ( meetingBlocks.length ) {
            for( let i in meetingBlocks ) {
                jQuery('#block-'+meetingBlocks[i].clientId).find('.submit-meeting').trigger('click');
            }
        }
        //wp.data.dispatch( 'core/editor' ).lockPostSaving( 'bpZoomMeetingBlocks' );
    })
})

// const unsubscribe = wp.data.subscribe(function () {
//     let select = wp.data.select('core/editor');
//     var isSavingPost = select.isSavingPost();
//     var isAutosavingPost = select.isAutosavingPost();
//     if (isSavingPost && !isAutosavingPost) {
//         unsubscribe();
//         wp.data.dispatch('core/notices').createNotice(
//             'error', // Can be one of: success, info, warning, error.
//             __( 'Please save the meeting.', 'buddyboss-pro' ), // Text string to display.
//             {
//                 isDismissible: true, // Whether the user can dismiss the notice.
//             }
//         );
//     }
// });
