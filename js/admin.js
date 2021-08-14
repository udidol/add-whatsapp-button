/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/admin/color-picker.js":
/*!**************************************!*\
  !*** ./src/js/admin/color-picker.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ ColorPicker)\n/* harmony export */ });\n/* harmony import */ var _module_base_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./module-base.js */ \"./src/js/admin/module-base.js\");\n\r\n\r\nclass ColorPicker extends _module_base_js__WEBPACK_IMPORTED_MODULE_0__.default {\r\n\tgetSelectors() {\r\n\t\treturn {\r\n\t\t\tbackgroundColorPicker: '.udi-bg-color-picker',\r\n\t\t\twhatsAppButton: '#whatsAppButton',\r\n\t\t\ttextColorPicker: '.udi-text-color-picker',\r\n\t\t\twpColorPicker: '.wp-color-picker',\r\n\t\t};\r\n\t}\r\n\r\n\tinitElements() {\r\n\t\tconst selectors = this.selectors;\r\n\r\n\t\tthis.elements = {\r\n\t\t\t$backgroundColorPicker: jQuery( selectors.backgroundColorPicker ),\r\n\t\t\t$whatsAppButton: jQuery( selectors.whatsAppButton ),\r\n\t\t\t$textColorPicker: jQuery( selectors.textColorPicker ),\r\n\t\t};\r\n\t}\r\n\r\n\tinit() {\r\n\t\tsuper.init();\r\n\r\n\t\tthis.initColorPickers();\r\n\t}\r\n\r\n\tinitColorPickers() {\r\n\t\tconst selectors = this.selectors;\r\n\r\n\t\tthis.elements.$backgroundColorPicker.wpColorPicker( {\r\n\t\t\t/**\r\n\t\t\t * Listen to a change in the color picker in order to update the button background in the preview screen with the picked color\r\n\t\t\t *\r\n\t\t\t * @param {Event} event - standard jQuery event, produced by whichever\r\n\t\t\t * control was changed.\r\n\t\t\t * @param {Object} ui - standard jQuery UI object, with a color member\r\n\t\t\t * containing a Color.js object.\r\n\t\t\t */\r\n\t\t\tchange: ( event, ui ) => {\r\n\t\t\t\tthis.elements.$whatsAppButton.css( 'background-color', ui.color.toString() );\r\n\t\t\t},\r\n\t\t\r\n\t\t\t/**\r\n\t\t\t * Listen in case the color picker is cleared, in order to update the button preview screen with the default color.\r\n\t\t\t *\r\n\t\t\t * @param {Event} event - standard jQuery event, produced by \"Clear\"\r\n\t\t\t * button.\r\n\t\t\t */\r\n\t\t\tclear: ( event ) => {\r\n\t\t\t\tconst element = jQuery( event.target ).siblings( selectors.wpColorPicker )[0];\r\n\t\t\r\n\t\t\t\tif ( element ) {\r\n\t\t\t\t\tthis.elements.$whatsAppButton.css( 'background-color', '#20B038' );\r\n\t\t\t\t}\r\n\t\t\t}\r\n\t\t} );\r\n\r\n\t\t// Change text color in preview according to input\r\n\t\tthis.elements.$textColorPicker.wpColorPicker( {\r\n\t\t\tchange: ( event, ui ) => {\r\n\t\t\t\tvar color = ui.color.toString();\r\n\t\t\r\n\t\t\t\tthis.elements.$whatsAppButton.css( 'color', color );\r\n\t\t\t},\r\n\t\t\r\n\t\t\tclear: ( event ) => {\r\n\t\t\t\tvar element = jQuery(event.target).siblings( selectors.wpColorPicker )[0];\r\n\t\t\r\n\t\t\t\tif ( element ) {\r\n\t\t\t\t\tthis.elements.$whatsAppButton.css( 'color', '#ffffff' );\r\n\t\t\t\t}\r\n\t\t\t}\r\n\t\t} );\r\n\t}\r\n}\n\n//# sourceURL=webpack://add-whatsapp-button/./src/js/admin/color-picker.js?");

/***/ }),

/***/ "./src/js/admin/manager.js":
/*!*********************************!*\
  !*** ./src/js/admin/manager.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _module_base_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./module-base.js */ \"./src/js/admin/module-base.js\");\n/* harmony import */ var _color_picker_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./color-picker.js */ \"./src/js/admin/color-picker.js\");\n/* harmony import */ var _settings_handler_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./settings-handler.js */ \"./src/js/admin/settings-handler.js\");\n\r\n\r\n\r\n\r\nclass AdminManager extends _module_base_js__WEBPACK_IMPORTED_MODULE_0__.default {\r\n\t/**\r\n\t * * Apply settings changes in the preview section\r\n\t */\r\n\t getSelectors() {\r\n\t\treturn {\r\n\t\t\tsubmitButton: 'form #submit',\r\n\t\t\tgeneralSettingsTabButton: '#gstablink',\r\n\t\t\tdesignTabButton: '#bdtablink',\r\n\t\t\tgeneralSettingsTabContent: '#gstab',\r\n\t\t\tdesignTabContent: '#bdtab',\r\n\t\t};\r\n\t}\r\n\r\n\tinitElements() {\r\n\t\tconst selectors = this.getSelectors();\r\n\r\n\t\tthis.elements = {\r\n\t\t\t$submitButton: jQuery( selectors.submitButton ),\r\n\t\t\t$generalSettingsTabButton: jQuery( selectors.generalSettingsTabButton ),\r\n\t\t\t$designTabButton: jQuery( selectors.designTabButton ),\r\n\t\t\t$generalSettingsTabContent: jQuery( selectors.generalSettingsTabContent ),\r\n\t\t\t$designTabContent: jQuery( selectors.designTabContent )\r\n\t\t};\r\n\t}\r\n\r\n\tinitModules() {\r\n\t\tthis.colorPicker = new _color_picker_js__WEBPACK_IMPORTED_MODULE_1__.default();\r\n\t\tthis.settingsHandler = new _settings_handler_js__WEBPACK_IMPORTED_MODULE_2__.default();\r\n\t}\r\n\r\n\tinit() {\r\n\t\tsuper.init();\r\n\r\n\t\tthis.initModules();\r\n\r\n\t\tthis.handleSettingsPageTabs();\r\n\t}\r\n\r\n\tbindEvents() {\r\n\t\tthis.elements.$submitButton.on( 'keypress', ( event ) => this.preventSubmitOnEnter( event ) );\r\n\t}\r\n\r\n\tpreventSubmitOnEnter( event ) {\r\n\t\treturn event.which !== 13;\r\n\t}\r\n\r\n\thandleSettingsPageTabs() {\r\n\t\t // Control Settings Tabs\r\n\t\t this.elements.$generalSettingsTabButton.on( 'click', () => {\r\n\t\t\tif ( ! this.elements.$generalSettingsTabContent.hasClass('awb-tab-active') ) {\r\n\t\t\t\tthis.elements.$generalSettingsTabContent.addClass('awb-tab-active');\r\n\t\t\t\tthis.elements.$generalSettingsTabButton.addClass('nav-tab-active');\r\n\t\t\t\tthis.elements.$designTabButton.removeClass('nav-tab-active');\r\n\t\t\t\tthis.elements.$designTabContent.removeClass('awb-tab-active');\r\n\t\t\t}\r\n\t\t} );\r\n\r\n\t\tthis.elements.$designTabButton.on( 'click', () => {\r\n\t\t\tif ( ! this.elements.$designTabContent.hasClass('awb-tab-active') ) {\r\n\t\t\t\tthis.elements.$designTabContent.addClass('awb-tab-active');\r\n\t\t\t\tthis.elements.$designTabButton.addClass('nav-tab-active');\r\n\t\t\t\tthis.elements.$generalSettingsTabButton.removeClass('nav-tab-active');\r\n\t\t\t\tthis.elements.$generalSettingsTabContent.removeClass('awb-tab-active');\r\n\t\t\t}\r\n\t\t} );\r\n\t}\r\n}\r\n\r\njQuery( document ).ready( () => new AdminManager() );\n\n//# sourceURL=webpack://add-whatsapp-button/./src/js/admin/manager.js?");

/***/ }),

/***/ "./src/js/admin/module-base.js":
/*!*************************************!*\
  !*** ./src/js/admin/module-base.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ ModuleBase)\n/* harmony export */ });\nclass ModuleBase {\r\n\tconstructor() {\r\n\t\tjQuery( document ).ready( ( $ ) => {\r\n\t\t\tthis.init();\r\n\t\t} );\r\n\t}\r\n\r\n\tgetSelectors() {\r\n\t\treturn {};\r\n\t}\r\n\r\n\tinitSettings() {\r\n\t\tif ( ! this.selectors ) {\r\n\t\t\tthis.selectors = this.getSelectors();\r\n\t\t}\r\n\t}\r\n\r\n\tinitElements() {\r\n\t\tthis.elements = {};\r\n\t}\r\n\r\n\tbindEvents() {}\r\n\r\n\tinit() {\r\n\t\tthis.initSettings();\r\n\t\tthis.initElements();\r\n\t\tthis.bindEvents();\r\n\t}\r\n}\n\n//# sourceURL=webpack://add-whatsapp-button/./src/js/admin/module-base.js?");

/***/ }),

/***/ "./src/js/admin/settings-handler.js":
/*!******************************************!*\
  !*** ./src/js/admin/settings-handler.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ SettingsHandler)\n/* harmony export */ });\n/* harmony import */ var _module_base_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./module-base.js */ \"./src/js/admin/module-base.js\");\n\r\n\r\nclass SettingsHandler extends _module_base_js__WEBPACK_IMPORTED_MODULE_0__.default {\r\n\tgetSelectors() {\r\n\t\treturn {\r\n\t\t\twhatsAppbuttonContainer: '#admin_wab_cont',\r\n\t\t\tbuttonText: '#wab-text',\r\n\t\t\tbuttonTypeSelect: '#awb_settings\\\\[button_type\\\\]',\r\n\t\t\twhatsAppButton: '#whatsAppButton',\r\n\t\t\tbuttonIconSizeInput: '#awb_settings\\\\[icon_size\\\\]',\r\n\t\t\tbuttonIconSizeMeasurementUnitInput: '#awb_settings\\\\[icon_size_mu\\\\]',\r\n\t\t\tbuttonTextInput: '#awb_settings\\\\[button_text\\\\]',\r\n\t\t\tbreakpointCheckbox: '#awb_settings\\\\[enable_breakpoint\\\\]',\r\n\t\t\tbreakpointContainer: '#awb_breakpoint',\r\n\t\t\thideButtonCheckbox: '#awb_settings\\\\[enable_hide_button\\\\]',\r\n\t\t\thideButtonContainer: '#awb_hide_button',\r\n\t\t\tlimitHoursCheckbox: '#awb_settings\\\\[limit_hours\\\\]',\r\n\t\t\tlimitHoursContainer: '#awb_limit_hours',\r\n\t\t\tdefaultMessageCheckbox: '#awb_settings\\\\[enable_message\\\\]',\r\n\t\t\tdefaultMessageContainer: '#awb_enable_message',\r\n\t\t\tbuttonBackground: '#awb_settings\\\\[button_bg_color\\\\]',\r\n\t\t\tbuttonTextColor: '#awb_settings\\\\[button_text_color\\\\]',\r\n\t\t\tbuttonLocationSelect: '#awb_settings\\\\[button_location\\\\]',\r\n\t\t\tdistanceFromBottomInput: '#awb_settings\\\\[distance_from_bottom\\\\]',\r\n\t\t\tdistanceFromBottomMeasurementUnitInput: '#awb_settings\\\\[distance_from_bottom_mu\\\\]',\r\n\t\t\ticonSizeSettingRow: '#iconSizeSettingRow',\r\n\t\t\tdisplayNone: 'awb-hide'\r\n\t\t};\r\n\t}\r\n\r\n\tinitElements() {\r\n\t\tconst selectors = this.selectors;\r\n\r\n\t\tthis.elements = {\r\n\t\t\t$buttonContainer: jQuery( selectors.whatsAppbuttonContainer ),\r\n\t\t\t$buttonText: jQuery( selectors.buttonText ),\r\n\t\t\t$buttonTypeSelect: jQuery( selectors.buttonTypeSelect ),\r\n\t\t\t$buttonIconSizeInput: jQuery( selectors.buttonIconSizeInput ),\r\n\t\t\t$buttonIconSizeMeasurementUnitInput: jQuery( selectors.buttonIconSizeMeasurementUnitInput ),\r\n\t\t\t$buttonTextInput: jQuery( selectors.buttonTextInput ),\r\n\t\t\t$breakpointCheckbox: jQuery( selectors.breakpointCheckbox ),\r\n\t\t\t$breakpointContainer: jQuery( selectors.breakpointContainer ),\r\n\t\t\t$hideButtonCheckbox: jQuery( selectors.hideButtonCheckbox ),\r\n\t\t\t$hideButtonContainer: jQuery( selectors.hideButtonContainer ),\r\n\t\t\t$limitHoursCheckbox: jQuery( selectors.limitHoursCheckbox ),\r\n\t\t\t$limitHoursContainer: jQuery( selectors.limitHoursContainer ),\r\n\t\t\t$defaultMessageCheckbox: jQuery( selectors.defaultMessageCheckbox ),\r\n\t\t\t$defaultMessageContainer: jQuery( selectors.defaultMessageContainer ),\r\n\t\t\t$buttonBackground: jQuery( selectors.buttonBackground ),\r\n\t\t\t$buttonTextColor: jQuery( selectors.buttonTextColor ),\r\n\t\t\t$buttonLocationSelect: jQuery( selectors.buttonLocationSelect ),\r\n\t\t\t$distanceFromBottomInput: jQuery( selectors.distanceFromBottomInput ),\r\n\t\t\t$distanceFromBottomMeasurementUnitInput: jQuery( selectors.distanceFromBottomMeasurementUnitInput ),\r\n\t\t\t$iconSizeSettingRow: jQuery( selectors.iconSizeSettingRow ),\r\n\t\t\t$whatsAppButton: jQuery( selectors.whatsAppButton )\r\n\t\t};\r\n\t}\r\n\r\n\tbindEvents() {\r\n\t\t// Update icon size according to the size input.\r\n\t\tthis.elements.$buttonIconSizeInput.on( 'input', () => this.updateIconSize() );\r\n\t\t// Update icon size according to the selected measurement unit.\r\n\t\tthis.elements.$buttonIconSizeMeasurementUnitInput.on( 'change', () => this.updateIconSize() );\r\n\t\t// Change the button in the preview according to the selected button type.\r\n\t\tthis.elements.$buttonTypeSelect.on( 'change', () => this.updateButtonType() );\r\n\t\t// Update button text in the preview in real time according to input value.\r\n\t\tthis.elements.$buttonTextInput.on( 'keyup', () => this.elements.$whatsAppButton.html( this.elements.$buttonTextInput.val() ) )\r\n\t\t// Display breakpoint input box if breakpoint checkbox is checked, hide otherwise.\r\n\t\tthis.elements.$breakpointCheckbox.on( 'change', () => this.elements.$breakpointContainer.toggleClass( 'awb-hide' ) );\r\n\t\t// Display button hide options (radio buttons) box if the 'Hide Button' checkbox is checked, hide otherwise.\r\n\t\tthis.elements.$hideButtonCheckbox.on( 'change', () => this.elements.$hideButtonContainer.toggleClass( 'awb-hide' ) );\r\n\t\t// Display 'Display Times' input boxes if the \"Limit Display Time\" checkbox is checked, hide otherwise.\r\n\t\tthis.elements.$limitHoursCheckbox.on( 'change', () => this.elements.$limitHoursContainer.toggleClass( 'awb-hide' ) );\r\n\t\t// Display Default Message Textarea if the \"Default Message\" checkbox is checked, hide otherwise.\r\n\t\tthis.elements.$defaultMessageCheckbox.on( 'change', () => this.elements.$defaultMessageContainer.toggleClass( 'awb-hide' ) );\r\n\t\t// Update the whatsApp button's background color according to the color picker value.\r\n\t\tthis.elements.$buttonBackground.on( 'change', () => this.elements.$whatsAppButton.css( 'background-color', this.elements.$buttonBackground.val() ) );\r\n\t\t// Update the button's text color in the preview when the color picker value changes.\r\n\t\tthis.elements.$buttonTextColor.on( 'change',  () => this.updateButtonTextColor() );\r\n\t\t// Control the button location on the preview mockup.\r\n\t\tthis.elements.$buttonLocationSelect.on( 'change', () => this.updateButtonLocation() );\r\n\t\t// Change button's distance from bottom (and whether it is determined by % or px)\r\n\t\tthis.elements.$distanceFromBottomInput.on( 'change', () => this.updateDistanceFromBottom() );\r\n\t\tthis.elements.$distanceFromBottomMeasurementUnitInput.on( 'change', () => this.updateDistanceFromBottom() );\r\n\r\n\t}\r\n\r\n\tupdateIconSize() {\r\n\t\tif ( 'wab-icon-plain' !== this.elements.$buttonTypeSelect.val() ) {\r\n\t\t\treturn;\r\n\t\t}\r\n\t\r\n\t\tconst size = this.elements.$buttonIconSizeInput.val() + this.elements.$buttonIconSizeMeasurementUnitInput.val();\r\n\t\r\n\t\tthis.elements.$whatsAppButton.css( 'width', size );\r\n\t\tthis.elements.$whatsAppButton.css( 'height', size );\r\n\t}\r\n\r\n\tupdateButtonType() {\r\n\t\tconst selectedValue = this.elements.$buttonTypeSelect.val();\r\n\r\n\t\tthis.elements.$buttonContainer.removeClass( 'wab-side-rectangle wab-bottom-rectangle wab-icon-plain' );\r\n\t\tthis.elements.$buttonContainer.addClass( selectedValue );\r\n\t\t\r\n\t\tif ( 'wab-icon-plain' === selectedValue ) {\r\n\t\t\t// Hide the button text if the button is an icon.\r\n\t\t\tthis.elements.$buttonText.addClass( this.selectors.displayNone );\r\n\t\t\t// Show the icon size control if the button is an icon.\r\n\t\t\tthis.elements.$iconSizeSettingRow.removeClass( this.selectors.displayNone );\r\n\t\t} else {\r\n\t\t\t// Show the button text if the nutton is not an icon.\r\n\t\t\tthis.elements.$buttonText.removeClass( this.selectors.displayNone );\r\n\t\t\t// Hide the icon size setting if the button is not an icon.\r\n\t\t\tthis.elements.$iconSizeSettingRow.addClass( this.selectors.displayNone );\r\n\t\t}\r\n\r\n\t\tif ( 'wab-bottom-rectangle' === selectedValue ) {\r\n\t\t\tthis.elements.$buttonContainer.css( 'bottom', '' );\r\n\t\t}\r\n\t}\r\n\r\n\tupdateButtonText() {\r\n\t\tif ( ! this.elements.$whatsAppButton.length ) {\r\n\t\t\tthis.elements.$whatsAppButton = jQuery( this.selectors.whatsAppButton );\r\n\t\t}\r\n\r\n\t\tthis.elements.$whatsAppButton.html( this.elements.$buttonTextInput.value )\r\n\t}\r\n\r\n\tupdateButtonTextColor() {\r\n\t\tif ( this.elements.$buttonTextColor.value ) {\r\n\t\t\tthis.elements.$whatsAppButton.css( 'color', this.elements.$buttonTextColor.value );\r\n\t\t} else {\r\n\t\t\tthis.elements.$whatsAppButton.css( 'color', '#ffffff' );\r\n\t\t}\r\n\t}\r\n\r\n\tupdateButtonLocation() {\r\n\t\tif ( this.elements.$buttonLocationSelect.val() == 'right' ) {\r\n\t\t\tthis.elements.$buttonContainer.addClass( 'wab-pull-right' );\r\n\t\t\tthis.elements.$buttonContainer.removeClass( 'wab-pull-left' );\r\n\t\t} else if ( this.elements.$buttonLocationSelect.val() == 'left' ) {\r\n\t\t\tthis.elements.$buttonContainer.addClass( 'wab-pull-left' );\r\n\t\t\tthis.elements.$buttonContainer.removeClass( 'wab-pull-right' );\r\n\t\t}\r\n\t}\r\n\r\n\tupdateDistanceFromBottom() {\r\n\t\tthis.elements.$buttonContainer.css( 'bottom', this.elements.$distanceFromBottomInput.val() + this.elements.$distanceFromBottomMeasurementUnitInput.val() );\r\n\t}\r\n}\n\n//# sourceURL=webpack://add-whatsapp-button/./src/js/admin/settings-handler.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/js/admin/manager.js");
/******/ 	
/******/ })()
;