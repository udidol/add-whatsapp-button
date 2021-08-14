export default class ModuleBase {
	constructor() {
		jQuery( document ).ready( ( $ ) => {
			this.init();
		} );
	}

	getSelectors() {
		return {};
	}

	initSettings() {
		if ( ! this.selectors ) {
			this.selectors = this.getSelectors();
		}
	}

	initElements() {
		this.elements = {};
	}

	bindEvents() {}

	init() {
		this.initSettings();
		this.initElements();
		this.bindEvents();
	}
}