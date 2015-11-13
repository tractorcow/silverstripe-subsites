(function($) {
	$.entwine('ss', function($) {
		$("select[name='CopyContentFromID_SubsiteID']").entwine({
			onchange: function() {
				$('.SubsitesTreeDropdownField').refresh();
			}
		});
		
		$('.SubsitesTreeDropdownField').entwine({
			
			/**
			 * Get the subsite id selector html dom entity
			 * 
			 * @returns {object}
			 */
			subsiteSelector: function() {
				return $("select[name='CopyContentFromID_SubsiteID']");
			},
			
			/**
			 * Update the linked page selector with the current subsite id
			 */
			refresh: function() {
				this.loadTree();
			},
			
			/**
			 * Get subsite id
			 * 
			 * @returns {Integer}
			 */
			subsiteID: function() {
				return this
					.subsiteSelector()
					.first()
					.val();
			},
	
			getRequestParams: function() {
				var name = this.find(':input:hidden').attr('name'),
					obj = {};
				obj[name + '_SubsiteID'] = this.subsiteID();
				return obj;
			}
		});
	});
})(jQuery);
