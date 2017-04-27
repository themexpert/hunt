import Hunt from './config/Hunt'

/**
 * Sets the page title
 *
 * @param title
 */
Hunt.pageTitle = title => {
    document.title = 'Hunt - ' + title + ' ';
};

/**
 * Re-renders/re-initiates components
 *
 * @param pageTitle
 */
Hunt.renderPage = (pageTitle) => {
    if(pageTitle!=undefined) Hunt.pageTitle(pageTitle);
    let btnCollapse = $('.button-collapse');
    if (btnCollapse.length > 0) btnCollapse.sideNav();
    let mdl = $('.modal');
    if (mdl.length > 0) mdl.modal();
    setTimeout(()=>{Materialize.updateTextFields();},200);
    let collaps = $('.collapsible');
    if(collaps.length>0) collaps.collapsible();
    let toolTip = $('[data-tooltip]');
    if(toolTip.length>0) toolTip.tooltip();
    let dropdowns = $(".dropdown");
    if(dropdowns.length>0) dropdowns.dropdown();
    window.scrollTo(0,0);
};

/**
 * Shows toaster message
 * @param msg
 * @param type
 * @param time
 */
Hunt.toast = (msg, type, time) => {
    time = time==undefined?4000:time;
    let bgColor = '';
    switch (type) {
        case 'success':
            bgColor = 'success';
            break;
        case 'error':
            bgColor = 'error';
            break;
        case 'warning':
            bgColor = 'warning';
            break;
        case 'info':
            bgColor = 'info';
            break;
    }
    Materialize.toast(msg, time, bgColor);
};
/**
 * Holds the scroll events and unique identifier
 *
 * @type {{events: Array, index: Array}}
 */
const scrollEvents = {
    events: [],
    index: []
};

/**
 * Attaches scroll events
 *
 * @param el
 * @param fn
 */
Hunt.infiniteScroll = (el, fn) => {
    if(scrollEvents.index.indexOf(el)>-1) return;
    scrollEvents.events.push({
        el: el,
        fn: fn
    });
    scrollEvents.index.push(el);
};
let jQ = require('jquery');
let win=jQ(window);
jQ(window).scroll(function () {
    scrollEvents.events.forEach(x=>{
        if($(document).height()-win.height()==win.scrollTop())
            if($(x.el).length) x.fn.call(this);
    });
});