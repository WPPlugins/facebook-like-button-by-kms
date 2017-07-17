// init facebook
// have to look for FBL_LANG_DEFINED
var FBL_LANG_DEFINED = FBL_LANG_DEFINED || 'en_US';
(function(lang) {
    var e = document.createElement('script');
    e.async = true;
    e.src = document.location.protocol + '//connect.facebook.net/' + lang + '/all.js#appId=132152313502382&xfbml=1';
    document.getElementsByTagName('head')[0].appendChild(e);
}(FBL_LANG_DEFINED));
