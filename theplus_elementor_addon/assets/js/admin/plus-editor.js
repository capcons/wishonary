jQuery( window ).on( 'elementor:init', function() {

	// Query Control

	var PlusQuery = elementor.modules.controls.Select2.extend( {

		cache: null,
		isTitlesReceived: false,

		getSelect2Placeholder: function getSelect2Placeholder() {
			return {
				id: '',
				text: 'All',
			};
		},

		getSelect2DefaultOptions: function getSelect2DefaultOptions() {
			var self = this;

			return jQuery.extend( elementor.modules.controls.Select2.prototype.getSelect2DefaultOptions.apply( this, arguments ), {
				ajax: {
					transport: function transport( params, success, failure ) {
						var data = {
							q 			: params.data.q,
							query_type 	: self.model.get('query_type'),
							object_type : self.model.get('object_type'),
						};

						return elementorCommon.ajax.addRequest('plus_query_control_filter_autocomplete', {
							data 	: data,
							success : success,
							error 	: failure,
						});
					},
					data: function data( params ) {
						return {
							q 	 : params.term,
							page : params.page,
						};
					},
					cache: true
				},
				escapeMarkup: function escapeMarkup(markup) {
					return markup;
				},
				minimumInputLength: 2
			});
		},

		getValueTitles: function getValueTitles() {
			var self 		= this,
			    ids 		= this.getControlValue(),
			    queryType 	= this.model.get('query_type');
			    objectType 	= this.model.get('object_type');

			if ( ! ids || ! queryType ) return;

			if ( ! _.isArray( ids ) ) {
				ids = [ ids ];
			}

			elementorCommon.ajax.loadObjects({
				action 	: 'plus_query_control_value_titles',
				ids 	: ids,
				data 	: {
					query_type 	: queryType,
					object_type : objectType,
					unique_id 	: '' + self.cid + queryType,
				},
				success: function success(data) {
					self.isTitlesReceived = true;
					self.model.set('options', data);
					self.render();
				},
				before: function before() {
					self.addSpinner();
				},
			});
		},

		addSpinner: function addSpinner() {
			this.ui.select.prop('disabled', true);
			this.$el.find('.elementor-control-title').after('<span class="elementor-control-spinner">&nbsp;<i class="fa fa-spinner fa-spin"></i>&nbsp;</span>');
		},

		onReady: function onReady() {
			setTimeout( elementor.modules.controls.Select2.prototype.onReady.bind(this) );

			if ( ! this.isTitlesReceived ) {
				this.getValueTitles();
			}
		}

	} );

	// Add Control Handlers
	elementor.addControlView( 'plus-query', PlusQuery );
} );