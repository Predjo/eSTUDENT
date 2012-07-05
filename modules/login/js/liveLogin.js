//LIVE LOGIN functions

function setMe() {

	if (meImgInitialized) return;

	var session = WL.getSession(),
		token = session != null ? session.access_token : null;

	if (token != null) {
		//var url = "https://apis.live.net/v5.0/me/picture?access_token=" + escape(token);
		//imgTagString = "<img src='" + url + "' />";
		//imgHolder.innerHTML = imgTagString;
		


		WL.api({ path: "me", method: "get" }, function (response) {
			if (!response.error) {
			   //document.getElementById("meName").innerHTML = response.first_name + " " + response.last_name;
			   //document.getElementById("meID").innerHTML = "Tvoj email je " + response.emails.account;
			   loginViaLive(response.emails.account);

			}
		});
	}

}

// Update the following values
var client_id = "000000004809C488",
	scope = ["wl.signin", "wl.basic", "wl.offline_access", "wl.emails"],
	redirect_uri = "http://jezgra.estudent.hr/modules/login/php/callback.php";

var meImgInitialized = false;


WL.Event.subscribe("auth.login", function () {
	setMe();
});

WL.Event.subscribe("auth.logout", function () {
	
});

WL.init({ client_id: client_id, redirect_uri: redirect_uri, response_type: "code", scope: scope  });

WL.ui({ name: "signin", element: "signin", scope: scope });