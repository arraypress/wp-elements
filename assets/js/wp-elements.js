/**
 * WP Elements - Minimal JavaScript
 * 
 * Handles interactive state for elements that need JS:
 * - Button group selection visual state
 * - Range slider live output updates
 * 
 * This is optional - the fields work without JS, but this improves UX.
 */

(function() {
	'use strict';

	/**
	 * Initialize when DOM is ready
	 */
	function init() {
		initButtonGroups();
		initRangeSliders();
	}

	/**
	 * Button group selection state
	 * Updates visual state when radio/checkbox inputs change
	 */
	function initButtonGroups() {
		document.querySelectorAll('.button-group__input').forEach(function(input) {
			input.addEventListener('change', function() {
				var group = this.closest('.button-group');
				var isMultiple = group.classList.contains('button-group--multiple');
				
				if (!isMultiple) {
					// Single selection - clear all
					group.querySelectorAll('.button-group__item').forEach(function(item) {
						item.classList.remove('is-selected');
					});
				}
				
				// Update clicked item
				var item = this.closest('.button-group__item');
				if (this.checked) {
					item.classList.add('is-selected');
				} else {
					item.classList.remove('is-selected');
				}
			});
			
			// Set initial state
			if (input.checked) {
				input.closest('.button-group__item').classList.add('is-selected');
			}
		});
	}

	/**
	 * Range slider live output
	 * Updates output element as slider moves
	 */
	function initRangeSliders() {
		document.querySelectorAll('.range-field-wrapper input[type="range"]').forEach(function(range) {
			var wrapper = range.closest('.range-field-wrapper');
			var output = wrapper.querySelector('.range-output');
			var unit = wrapper.dataset.unit || '';
			
			if (output) {
				range.addEventListener('input', function() {
					output.textContent = this.value + unit;
				});
			}
		});
	}

	// Initialize on DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
