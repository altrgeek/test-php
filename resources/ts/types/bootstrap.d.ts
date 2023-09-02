/* eslint-disable import/no-extraneous-dependencies */
import Bootstrap from 'bootstrap';

interface JQuery<TElement = HTMLElement> extends JQueryStatic {
    /**
     * If no _method_ is specified, makes an alert listen for click events on descendant elements which have the `data-dismiss="alert"` attribute.
     * (Not necessary when using the data-api's auto-initialization.)
     * Otherwise, call the method on the alert element:
     * * `close` – Closes an alert by removing it from the DOM. If the `.fade` and `.show` classes are present on the element, the alert will fade out before it is removed.
     * * `dispose` – Destroys an element's alert.
     */
    alert(action?: 'close' | 'dispose'): this;

    /**
     * Call a method on the button element:
     * * `toggle` – Toggles push state. Gives the button the appearance that it has been activated.
     * * `dispose` – Destroys an element's button.
     */
    button(action: 'toggle' | 'dispose'): this;

    /**
     * Call a method on the carousel element:
     * * `cycle` – Cycles through the carousel items from left to right.
     * * `pause` – Stops the carousel from cycling through items.
     * * _number_ – Cycles the carousel to a particular frame (0 based, similar to an array).
     * * `prev` – Cycles to the previous item.
     * * `next` – Cycles to the next item.
     * * `dispose` – Destroys an element's carousel.
     *
     * Returns to the caller before the target item has been shown (i.e. before the `slid.bs.carousel` event occurs).
     */
    carousel(action: 'cycle' | 'pause' | number | 'prev' | 'next' | 'dispose'): this;
    /**
     * Initializes the carousel and starts cycling through items.
     */
    carousel(options?: Bootstrap.CarouselOption): this;

    /**
     * Call a method on the collapsible element:
     * * `toggle` – Toggles a collapsible element to shown or hidden.
     * * `show` – Shows a collapsible element.
     * * `hide` – Hides a collapsible element.
     * * `dispose` – Destroys an element's collapse.
     *
     * Returns to the caller before the collapsible element has actually been shown or hidden (i.e. before the `shown.bs.collapse` or `hidden.bs.collapse` event occurs).
     */
    collapse(action: 'toggle' | 'show' | 'hide' | 'dispose'): this;
    /**
     * Activates a content as a collapsible element.
     */
    collapse(options?: Bootstrap.CollapseOption): this;

    /**
     * Call a method on the dropdown element:
     * * `toggle` – Toggles the dropdown menu of a given navbar or tabbed navigation.
     * * `show` – Shows the dropdown menu of a given navbar or tabbed navigation.
     * * `hide` – Hides the dropdown menu of a given navbar or tabbed navigation.
     * * `update` – Updates the position of an element's dropdown.
     * * `dispose` – Destroys an element's dropdown.
     */
    dropdown(action: 'toggle' | 'show' | 'hide' | 'update' | 'dispose'): this;
    /**
     * Toggle contextual overlays for displaying lists of links.
     *
     * The data-api, `data-toggle="dropdown"` is always required to be present on the dropdown's trigger element.
     */
    dropdown(options?: Bootstrap.DropdownOption): this;

    /**
     * Call a method on the modal element:
     * * `toggle` – Manually toggles a modal.
     * * `show` – Manually opens a modal.
     * * `hide` – Manually hides a modal.
     * * `handleUpdate` – Manually readjust the modal's position if the height of a modal changes while it is open (i.e. in case a scrollbar appears).
     * * `dispose` – Destroys an element's modal.
     *
     * Returns to the caller before the modal has actually been shown or hidden (i.e. before the `shown.bs.modal` or `hidden.bs.modal` event occurs).
     */
    modal(action: 'toggle' | 'show' | 'hide' | 'handleUpdate' | 'dispose'): this;
    /**
     * Activates a content as a modal.
     */
    modal(options?: Bootstrap.ModalOption): this;

    /**
     * Call a method on the popover element:
     * * `show` – Reveals an element's popover. Popovers whose both title and content are zero-length are never displayed.
     * * `hide` – Hides an element's popover.
     * * `toggle` – Toggles an element's popover.
     * * `dispose` – Hides and destroys an element's popover.
     * Popovers that use delegation (which are created using the `selector` option) cannot be individually destroyed on descendant trigger elements.
     * * `enable` – Gives an element's popover the ability to be shown. Popovers are enabled by default.
     * * `disable` – Removes the ability for an element's popover to be shown. The popover will only be able to be shown if it is re-enabled.
     * * `toggleEnabled` – Toggles the ability for an element's popover to be shown or hidden.
     * * `update` – Updates the position of an element's popover.
     *
     * Returns to the caller before the popover has actually been shown or hidden (i.e. before the `shown.bs.popover` or `hidden.bs.popover` event occurs).
     * This is considered a "manual" triggering of the popover.
     */
    popover(
        action:
            | 'show'
            | 'hide'
            | 'toggle'
            | 'dispose'
            | 'enable'
            | 'disable'
            | 'toggleEnabled'
            | 'update'
    ): this;
    /**
     * Initializes popovers for an element collection.
     */
    popover(options?: Bootstrap.PopoverOption): this;

    // tslint:disable:jsdoc-format
    /**
         * Call a method on the scrollspy element:
         * * `refresh` – When using scrollspy in conjunction with adding or removing of elements from the DOM, you'll need to call the refresh, see example.
         * * `dispose` – Destroys an element's scrollspy.
         *
         * @example
```javascript
$('[data-spy="scroll"]').each(function () {
   var $spy = $(this).scrollspy('refresh')
})
```
         */
    // tslint:enable:jsdoc-format
    scrollspy(action: 'refresh' | 'dispose'): this;
    /**
     * Add scrollspy behavior to a topbar navigation.
     */
    scrollspy(options?: Bootstrap.ScrollspyOption): this;

    /**
     * Call a method on the list item or tab element:
     * * `show` – Selects the given list item or tab and shows its associated pane.
     * Any other list item or tab that was previously selected becomes unselected and its associated pane is hidden.
     * * `dispose` – Destroys an element's tab.
     *
     * Returns to the caller before the tab pane has actually been shown (i.e. before the `shown.bs.tab` event occurs).
     */
    tab(action: 'show' | 'dispose'): this;

    /**
     * Call a method on the toast element:
     * * `show` – Reveals an element's toast. You have to manually call this method, instead your toast won't show.
     * * `hide` – Hides an element's toast. You have to manually call this method if you made `autohide` to false.
     * * `dispose` – Hides an element's toast. Your toast will remain on the DOM but won't show anymore.
     *
     * Returns to the caller before the toast has actually been shown or hidden (i.e. before the `shown.bs.toast` or `hidden.bs.toast` event occurs).
     */
    toast(action: 'show' | 'hide' | 'dispose'): this;
    /**
     * Attaches a toast handler to an element collection.
     */
    toast(options?: Bootstrap.ToastOption): this;

    /**
     * Call a method on the tooltip element:
     * * `show` – Reveals an element's tooltip. Tooltips with zero-length titles are never displayed.
     * * `hide` – Hides an element's tooltip.
     * * `toggle` – Toggles an element's tooltip.
     * * `dispose` – Hides and destroys an element's tooltip.
     * Tooltips that use delegation (which are created using `selector` option) cannot be individually destroyed on descendant trigger elements.
     * * `enable` – Gives an element's tooltip the ability to be shown. Tooltips are enabled by default.
     * * `disable` – Removes the ability for an element's tooltip to be shown. The tooltip will only be able to be shown if it is re-enabled.
     * * `toggleEnabled` – Toggles the ability for an element's tooltip to be shown or hidden.
     * * `update` – Updates the position of an element's tooltip.
     *
     * Returns to the caller before the tooltip has actually been shown or hidden (i.e. before the `shown.bs.tooltip` or `hidden.bs.tooltip` event occurs).
     * This is considered a "manual" triggering of the tooltip.
     */
    tooltip(
        action:
            | 'show'
            | 'hide'
            | 'toggle'
            | 'dispose'
            | 'enable'
            | 'disable'
            | 'toggleEnabled'
            | 'update'
    ): this;
    /**
     * Attaches a tooltip handler to an element collection.
     */
    tooltip(options?: Bootstrap.TooltipOption): this;

    on(
        events: Bootstrap.CarouselEvent,
        handler: JQuery.EventHandlerBase<TElement, Bootstrap.CarouselEventHandler<TElement>>
    ): this;
    on(
        events: Bootstrap.DropdownEvent,
        handler: JQuery.EventHandlerBase<TElement, Bootstrap.DropdownsEventHandler<TElement>>
    ): this;
    on(
        events: Bootstrap.ModalEvent,
        handler: JQuery.EventHandlerBase<TElement, Bootstrap.ModalEventHandler<TElement>>
    ): this;
    on(
        events: Bootstrap.TapEvent,
        handler: JQuery.EventHandlerBase<TElement, Bootstrap.TapEventHandler<TElement>>
    ): this;
    on(
        events:
            | Bootstrap.AlertEvent
            | Bootstrap.CollapseEvent
            | Bootstrap.PopoverEvent
            | Bootstrap.ScrollspyEvent
            | Bootstrap.ToastEvent
            | Bootstrap.TooltipEvent,
        handler: JQuery.EventHandler<TElement>
    ): this;
}

export default jQuery;
