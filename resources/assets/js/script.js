import Hunt from './config/Hunt'

Hunt.pageTitle = title => {
    document.title = 'Hunt - ' + title + ' ';
};

Hunt.renderPage = (pageTitle) => {
    if(pageTitle!=undefined) Hunt.pageTitle(pageTitle);
    let btnCollapse = $('.button-collapse');
    if (btnCollapse.length > 0) btnCollapse.sideNav();
    let mdl = $('.modal');
    if (mdl.length > 0) mdl.modal();
    let slct = $('select');
    if(slct.length>0) slct.material_select();
    setTimeout(()=>{Materialize.updateTextFields();},200);
    let collaps = $('.collapsible');
    if(collaps.length>0) collaps.collapsible();
    let toolTip = $('[data-tooltip]');
    if(toolTip.length>0) toolTip.tooltip();
    Hunt.pace.start();
    window.scrollTo(0,0);
};

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