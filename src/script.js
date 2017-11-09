//No double tap to zoom
(function ($) {
	$.fn.nodoubletapzoom = function () {
		$(this).bind('touchstart', function preventZoom(e) {
			var t2 = e.timeStamp
				, t1 = $(this).data('lastTouch') || t2
				, dt = t2 - t1
				, fingers = e.originalEvent.touches.length;
			$(this).data('lastTouch', t2);
			if (!dt || dt > 600 || fingers > 1) return; // not double-tap

			e.preventDefault(); // double tap - prevent the zoom
			// also synthesize click events we just swallowed up
			$(this).trigger('click');
		});
	};
})(JQ);



var myTimer, mySeconds = 0, myMinutes = 0, myHours = 0, myTimeout;
JQ(function () {
	fnStartAll();
});

function fnStartAll() {

	myTimer = JQ('#timer');
	JQ(myTimer).text("00:00:00");

	$(".btnClose").click(function () {
		fnCloseMessage();
	});

	fnSetTouchButtons();

	(lxUserName.trim() == "") ? fnShowWelcome() : fnShowTetris();

	JQ("#frmUser").submit(function () {
		fnShowTetris();
		return false;
	});

	fnOrientatoinChange();
	window.addEventListener("orientationchange", function () {
		// Announce the new orientation number
		console.log("A");
		fnOrientatoinChange();
	}, false);


	document.addEventListener('touchmove', function (event) {
		if (event.scale !== 1) { event.preventDefault(); }
	}, false);

	JQ("#tetris, #gridCover").nodoubletapzoom();

	// JQ("#touchControls").click(function(e){
	// 	e.preventDefault();
	// 	console.log("A");
	// });

	// alert(JQ(window).width() + " : " + JQ(window).height() )
	// document.addEventListener('gesturestart', function (e) {
	// 	e.preventDefault();
	// });
	// document.addEventListener('touchmove', function(event) {
	// 	event = event.originalEvent || event;
	// 	if(event.scale > 1) {
	// 	  event.preventDefault();
	// 	}
	//   }, false);

}

function fnOrientatoinChange() {
	JQ("#touchControls").height(0).height(
		JQ("#tetris").height()
	);
}

function fnShowMessage(message) {
	JQ("#tetrisMessage").css("display", "block").animate({
		opacity: 1,
	}, 500, function () {
		tetris.pause();
	}).find(".msg").html(message);
}
function fnCloseMessage() {
	JQ("#tetrisMessage").animate({
		opacity: 0,
	}, 500, function () {
		JQ("#tetrisMessage").css("display", "none");
		tetris.resume();
	});
}

function fnGameOver() {
	if (lxGameOver == "1") {

		fnSaveDetails();
		var mess = "Game over<br />Total time taken : " + lxTime;
		fnShowMessage(
			"<div class='ttrisMessage'>" + mess + "</div>" +
			"<div class='spclButtons'>" +
			"<a href='javascript:fnRestartFresh(this)'>Restart</a>" +
			"<a href='javascript:fnRestartUser(this)'>Improve score</a>" +
			"<a href='javascript:fnShowLeaderBoard()'>Leaderboard</a>" +
			"</div>"
		);
	}

}

function fnLineMade(lxLine) {
	var mess1, mess2 = "";
	switch (lxLine) {
		case 1:
			mess1 = "Automation";
			mess2 = "Reduce the time and cost associated with responding to <br/>Requests for information and chargeback requests.";
			break;
		case 2:
			mess1 = "Reporting visibility";
			mess2 = "Quick and easy to generate reports and track chargeback trends <br/>with secure, real-time, web-based reporting and data tools";
			break;
		case 3:
			mess1 = "Compelling results";
			mess2 = "Increse your win rates and reversals, cut chargeback,<br />and boost your cash flow.";
			break;
		case 4:
			mess1 = "Poweful workflow management";
			mess2 = "An extensive workflow management capablility, from dynamic<br />skill-based routing to a unique document capture feature.";
			break;
		case 5:
			mess1 = "Automated workflow";
			mess2 = "Automated workflow enables the preload of standard support <br/>documents like T&amp;Cs, cancellation and return policies.";
			break;
		case 6:
			mess1 = "Document wizard";
			mess2 = "Identify which supporting documentation is best for <br/>representment by the payment brand reason code.";
			break;
		default:
			mess1 = "Benefit : " + lxLine;
	}

	if (lxLine <= 6) {
		fnShowMessage(
			"<div class='lineMsg'>"
			+ "<h3>Dispute Resolution Center</h3><h4>brings you..</h4>"
			+ "<h2>" + mess1 + "</h2>"
			+ "<h5>" + mess2 + "</h5>" +
			"</div>"
		);
	}
}

function myAdd() {
	mySeconds++;
	if (mySeconds >= 60) {
		mySeconds = 0;
		myMinutes++;
		if (myMinutes >= 60) {
			myMinutes = 0;
			myHours++;
		}
	}

	JQ(myTimer).text((myHours ? (myHours > 9 ? myHours : "0" + myHours) : "00") + ":" + (myMinutes ? (myMinutes > 9 ? myMinutes : "0" + myMinutes) : "00") + ":" + (mySeconds > 9 ? mySeconds : "0" + mySeconds));
	lxTime = JQ(myTimer).text();

	stTimer();
}
function stTimer() {
	myTimeout = setTimeout(myAdd, 1000);
}
function psTimer() {
	clearTimeout(myTimeout);
}


function fnSetTouchButtons() {

	var fnVibrate = function () {
		if ("vibrate" in navigator) {
			navigator.vibrate(100);
		}
	};

	JQ("#touchControls .left").click(function () {
		tetris.moveLeft();
	});
	JQ("#touchControls .right").click(function () {
		tetris.moveRight();
	});
	JQ("#touchControls .up").click(function () {
		tetris.rotate();
	});
	JQ("#touchControls .down").click(function () {
		tetris.moveDown();
	});


	JQ("#touchControls .ctrls, #touchControls").nodoubletapzoom();


}

function fnShowWelcome() {
	JQ("#welcome").delay(1000).fadeIn();
}

function fnShowUsername() {
	JQ("#welcome").fadeOut();
	JQ("#userDetails").delay(1000).fadeIn();
}

function fnShowTetris() {
	if (JQ.trim(JQ("#txtUser").val()) == "") {
		alert("Please specify your name to begin");
		JQ("#txtUser").focus();
		return false;
	}
	if (!isEmail(JQ.trim(JQ("#txtEmail").val()))) {
		alert("Please specify your email to begin");
		JQ("#txtEmail").focus();
		return false;
	}

	lxUserName = JQ.trim(JQ("#txtUser").val());
	lxUserEmail = JQ.trim(JQ("#txtEmail").val());

	JQ("#userDetails").fadeOut();
	JQ("#tetris").delay(1000).fadeIn();
	setTimeout(function () {
		tetris.start();
		stTimer();
	}, 2000);

}

function fnShowLeaderBoard() {
	JQ("#tetris").fadeOut();
	JQ("#leaderBoard").delay(1000).fadeIn();
	fnGetLeaderBoard();
}

function fnSaveDetails() {

	JQ("#hdnTime").val(lxTime);
	var url = "./services/saveUser.php?";
	url += "lines=" + lxLine;
	url += "&level=" + (tetris.level + 1);
	url += "&score=" + (tetris.score);
	var dataForm = JQ("#frmUser").serialize();
	JQ.post(url, dataForm, function (data) {
		console.log(data);
	});
}

function fnRestartFresh(obj) {
	JQ(obj).attr("href", "javascript:void(0)");
	setTimeout(function () {
		location.replace(location.origin + location.pathname);
	}, 1500);
}
function fnRestartUser(obj) {
	JQ(obj).attr("href", "javascript:void(0)");
	setTimeout(function () {
		location.replace(location.origin + location.pathname + "?user=" + lxUserName + "&email=" + lxUserEmail);
	}, 1500)
}
function fnGetLeaderBoard() {
	// JQ(obj).attr("href","javascript:void(0)");
	var url = "./services/leaderBoard.php?";
	url += "A=" + 1;
	url += "&B=" + 1;
	url += "&C=" + 1;
	JQ.get(url, function (data) {
		console.log(data);
		JQ("#leaderBoard .content").html(data);
	});
}

function isEmail(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}