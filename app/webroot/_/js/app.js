var $$ = Dom7;
var storage = "Personality";
var version = "1.0.01"; 
var testMode = "No";
var w3w = "8NGCA96J";
var w3wURL = "https://api.what3words.com/v2/";
var geoIPData = "http://gd.geobytes.com/GetCityDetails?";
//var server = "https://blockchainsage.net/assessment/";
var server = "https://blockchainsage.local/assessment/";

var app = new Framework7({
  root: '#app', // App root element
  id: 'io.framework7.myapp', // App bundle ID
  name: 'My App', // App name
  theme: 'auto', // Automatic theme detection
  // App root data
  data: function () {
    return {
      user: {
        firstName: 'John',
        lastName: 'Doe',
      },

    };
  },
  // App root methods
  methods: {
    helloWorld: function () {
      app.dialog.alert('Hello World!');
    },
  },
  // App routes
  routes: routes,

  // Register service worker
  serviceWorker: Framework7.device.cordova ? {} : {
    path: '/service-worker.js',
  },
  // Input settings
  input: {
    scrollIntoViewOnFocus: Framework7.device.cordova && !Framework7.device.electron,
    scrollIntoViewCentered: Framework7.device.cordova && !Framework7.device.electron,
  },
  // Cordova Statusbar settings
  statusbar: {
    iosOverlaysWebView: true,
    androidOverlaysWebView: false,
  },
  on: {
    init: function () {
      var f7 = this;
      if (f7.device.cordova) {
        // Init cordova APIs (see cordova-app.js)
        cordovaApp.init(f7);
      }
    },
  },
});

// Login Screen Demo
$$('#my-login-screen .login-button').on('click', function () {
  var username = $$('#my-login-screen [name="username"]').val();
  var password = $$('#my-login-screen [name="password"]').val();

  // Close login screen
  app.loginScreen.close('#my-login-screen');

  // Alert username and password
  app.dialog.alert('Username: ' + username + '<br>Password: ' + password);
});

app.request.setup({crossDomain:true});



function checkdata() {
	console.log("In");
	var formData = app.form.convertToData('#personality');

	if(formData.Name==""){
		app.dialog.alert("Please enter your Name.", "Personality Test")
		return false;
	}
	if(formData.Mobile==""){
		app.dialog.alert("Please enter mobile.", "Personality Test")
		return false;
	}
	if(formData.Mobile.length!=10){
		app.dialog.alert("Please enter correct mobile.", "Personality Test")
		return false;
	}
 if(formData.email==""){
   app.dialog.alert("Please enter correct email.", "Personality Test")
   app.input.focus("#email");
   return false;
  }
		if(ValidateEmail(formData.email)==false){
   app.dialog.alert("Please enter correct email.", "Personality Test")
   app.input.focus("#email");
   return false;
  }
	for(i=1;i<=50;i++){
		var fieldName = "#selected"+i;
		var field = "selected"+i;
		if( $$(fieldName).val() == 0){
			app.dialog.alert("Please select an option for question "+i,"Personality Test");
			app.input.focus(field);
			return false;
		}
	}		
  var submitURL = server+'';
  app.request.post(submitURL, formData, function (data) {
   var gotData = JSON.parse(data);
   if(gotData['success']=="Yes"){  
    var stringy = JSON.stringify(formData);
				localStorage.setItem(storage+'.Data',stringy);	
				success = "Yes";
				console.log("Yes");
				mainView.router.navigate('/assessment/');
				return false;
  }else{
    app.dialog.alert("Cannot get data of personality!!!", "Personality Test");
    success = "No";
				return false;
  }
 },
  function () 	{
   toastBottomNoInternet.open();
 });

	return false;
 //validation code 
}

function ValidateEmail(email) 
{
 var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(email.match(mailformat)) {
    return (true)
  }else{
    return (false)
		}
}
