/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
    
    $.cookieBar({   
        message: 'We use cookies to track usage and preferences',
        acceptButton: true,
        acceptText: 'I Understand',
        acceptFunction: null,
        declineButton: false,
        declineText: 'Disable Cookies',
        declineFunction: null,
        policyButton: false,
        policyText: 'Privacy Policy',
        policyURL: '/privacy-policy/',
        autoEnable: true,
        acceptOnContinue: false,
        acceptOnScroll: true,
        acceptAnyClick: false,
        expireDays: 365,
        renewOnVisit: false,
        forceShow: false,
        effect: 'slide',
        element: 'nav#navbar',
        append: false,
        fixed: false,
        bottom: false,
        zindex: '999',
        domain: 'www.example.com',
        referrer: 'www.example.com'
    });

    
});
