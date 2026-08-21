import ModuleBase from '../shared/module-base.js';

const PLUGIN_SLUG = 'add-whatsapp-button';
const SETTING_ENABLED = '1';
const DISMISSED_STORAGE_KEY = 'awb_button_dismissed';
const HIDDEN_CLASS = 'wab-hidden';

// Amount of the button, in pixels, that stays on screen once it is toggled off.
const SIDE_RECTANGLE_PEEK = 12;
const ICON_PEEK = 14;
const BOTTOM_RECTANGLE_PEEK = 12;

const BUTTON_TYPE = {
	SIDE_RECTANGLE: 'wab-side-rectangle',
	BOTTOM_RECTANGLE: 'wab-bottom-rectangle',
	ICON_PLAIN: 'wab-icon-plain'
};

const BUTTON_LOCATION = {
	LEFT: 'left',
	RIGHT: 'right'
};

const HIDE_BUTTON_TYPE = {
	FULL: 'full',
	HIDE: 'hide'
};

const CHEVRON_DIRECTION = {
	UP: 'up',
	DOWN: 'down',
	LEFT: 'left',
	RIGHT: 'right'
};

const CHEVRON_CLASS = {
	UP: 'wab-up',
	DOWN: 'wab-down',
	LEFT: 'wab-left',
	RIGHT: 'wab-right'
};

export default class WhatsAppButtonHandler extends ModuleBase {
	getSelectors() {
		return {
			buttonContainer: '#wab_cont',
			whatsAppButton: '#whatsAppButton',
			closeButton: '#wab_close',
			chevron: '#wab_close img.wab-chevron',
			dragHandle: '#wab_drag'
		};
	}

	initSettings() {
		super.initSettings();

		this.settings = window.wabSettings;
	}

	initElements() {
		const selectors = this.selectors;

		this.elements = {
			$buttonContainer: jQuery( selectors.buttonContainer ),
			$whatsAppButton: jQuery( selectors.whatsAppButton ),
			$closeButton: jQuery( selectors.closeButton ),
			$chevron: jQuery( selectors.chevron )
		};
	}

	bindEvents() {
		this.elements.$closeButton.on( 'click', () => this.onCloseButtonClick() );
	}

	init() {
		// The settings object is localized by Scripts_Manager alongside this script.
		if ( ! window.wabSettings ) {
			return;
		}

		super.init();

		if ( this.isButtonPreviouslyDismissed() ) {
			this.elements.$buttonContainer.hide();
			return;
		}

		this.initDragging();

		if ( this.settings.limitHours === SETTING_ENABLED ) {
			this.hideOutsideDisplayHours();
		}
	}

	getStorage() {
		return this.settings.hideButtonPersistence === 'persistent' ? localStorage : sessionStorage;
	}

	isButtonPreviouslyDismissed() {
		const persistence = this.settings.hideButtonPersistence;
		if ( persistence !== 'session' && persistence !== 'persistent' ) {
			return false;
		}
		return !! this.getStorage().getItem( DISMISSED_STORAGE_KEY );
	}

	storeDismissedState() {
		const persistence = this.settings.hideButtonPersistence;
		if ( persistence === 'session' || persistence === 'persistent' ) {
			this.getStorage().setItem( DISMISSED_STORAGE_KEY, '1' );
		}
	}

	initDragging() {
		if ( this.settings.dragEnabled !== SETTING_ENABLED ) {
			return;
		}

		this.elements.$buttonContainer.draggable( {
			axis: 'y',
			scroll: false,
			handle: this.selectors.dragHandle
		} );
	}

	getChevronUrl( direction ) {
		return `${ this.settings.plugins_url }/${ PLUGIN_SLUG }/img/chevron-${ direction }.svg`;
	}

	isHidden() {
		return this.elements.$buttonContainer.hasClass( HIDDEN_CLASS );
	}

	slideSideButtonOut() {
		const containerWidth = this.elements.$buttonContainer.outerWidth();
		let offset = '';

		if ( BUTTON_TYPE.SIDE_RECTANGLE === this.settings.button_type ) {
			offset = containerWidth - SIDE_RECTANGLE_PEEK + 'px';
		} else if ( BUTTON_TYPE.ICON_PLAIN === this.settings.button_type ) {
			offset = containerWidth - ICON_PEEK + 'px';
		}

		this.elements.$buttonContainer.css( this.settings.button_location, '-' + offset );
	}

	toggleBottomRectangle() {
		this.elements.$chevron.toggleClass( `${ CHEVRON_CLASS.DOWN } ${ CHEVRON_CLASS.UP }` );

		if ( this.elements.$chevron.hasClass( CHEVRON_CLASS.DOWN ) ) {
			this.elements.$chevron.attr( 'src', this.getChevronUrl( CHEVRON_DIRECTION.DOWN ) );
			this.elements.$buttonContainer.css( 'bottom', 0 );
			return;
		}

		const hiddenOffset = this.elements.$whatsAppButton.outerHeight() - BOTTOM_RECTANGLE_PEEK + 'px';

		this.elements.$chevron.attr( 'src', this.getChevronUrl( CHEVRON_DIRECTION.UP ) );
		this.elements.$buttonContainer.css( 'bottom', '-' + hiddenOffset );
	}

	toggleSideButton() {
		this.elements.$chevron.toggleClass( `${ CHEVRON_CLASS.LEFT } ${ CHEVRON_CLASS.RIGHT }` );

		if ( this.isHidden() ) {
			const chevronDirection = ( BUTTON_LOCATION.LEFT === this.settings.button_location ) ? CHEVRON_DIRECTION.RIGHT : CHEVRON_DIRECTION.LEFT;

			this.elements.$chevron.attr( 'src', this.getChevronUrl( chevronDirection ) );
			this.slideSideButtonOut();
			return;
		}

		this.elements.$chevron.attr( 'src', this.getChevronUrl( this.settings.button_location ) );
		this.elements.$buttonContainer.css( this.settings.button_location, 0 );
	}

	toggleButton() {
		this.elements.$buttonContainer.toggleClass( HIDDEN_CLASS );

		if ( BUTTON_TYPE.BOTTOM_RECTANGLE === this.settings.button_type ) {
			this.toggleBottomRectangle();
			return;
		}

		this.toggleSideButton();
	}

	onCloseButtonClick() {
		this.storeDismissedState();

		if ( HIDE_BUTTON_TYPE.FULL === this.settings.hideButtonType ) {
			this.elements.$buttonContainer.hide();
			return;
		}

		if ( HIDE_BUTTON_TYPE.HIDE === this.settings.hideButtonType ) {
			this.toggleButton();
		}
	}

	isOutsideDisplayHours() {
		const currentHour = new Date().getHours();

		return currentHour < parseInt( this.settings.startHour, 10 ) || currentHour > parseInt( this.settings.endHour, 10 );
	}

	hideOutsideDisplayHours() {
		if ( ! this.isOutsideDisplayHours() ) {
			return;
		}

		this.elements.$buttonContainer.css( 'display', 'none' );
	}
}
