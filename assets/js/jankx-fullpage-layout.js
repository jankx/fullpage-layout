var jankxFullpage = window.jankxFullpage || {};

if (jankxFullpage.backendEnabled) {
    var initialized = false
    var fullPageOptions = {
        sectionSelector: jankxFullpage.sectionSelector || '.section',
        credits: jankxFullpage.credits || {},
        navigation: (jankxFullpage.navigation || 1) == 1,
        navigationPosition: jankxFullpage.navigationPosition || 'right',
    };

    var jankxFullpage = new fullpage('.jankx-fullpage-wrapper', fullPageOptions);
    initialized = true;

    if (!jankxFullpage.mobileAllowed) {
        window.addEventListener('resize', function(){
            var mobileBreakpoint = jankxFullpage.mobileBreakpoint || 768;
            if (window.innerWidth < mobileBreakpoint && initialized) {
                jankxFullpage.destroy('all');
                initialized = false;
            } else if (!initialized) {
                jankxFullpage = new fullpage('.jankx-fullpage-wrapper', fullPageOptions);
                initialized = true;
            }
        });
    }
}
