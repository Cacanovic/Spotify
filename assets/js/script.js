var currentPlaylist=[];
var shufflePlaylist=[];
var tempPlaylist=[];
var audioElement;
var mouseDown=false;
var currentIndex=0;
var repeat=false;
var shuffle=false;
var userLoggedIn;
var timer;

$(document).click(function(click){
	var target=$(click.target);
	//provjeravamo da li element na koji smo kliknuli nema sledece klase
	//ako nema onda se sakriva options menu
	if(!target.hasClass("item") && !target.hasClass("optionsButton")){
		hideOptionsMenu();
	}
});

//na scrol misa se uklanja
$(window).scroll(function(){
	hideOptionsMenu();
});
//svaki put kad se dropdown promjeni
$(document).on("change", "select.playlist",function(){
	var select=$(this);
	var playlistId=select.val();
	//prev pronalazi input koji se nalazi u options menu
	var songId=select.prev(".songId").val();
	$.post("includes/handlers/ajax/addToPlaylist.php",{playlistId:playlistId, songId:songId})
		.done(function(error){
			if(error!=""){
				alert(error);
				return;
			}

			hideOptionsMenu();
			select.val("");
		});

});

function updateEmail(emailClass){
	var emailValue=$("."+ emailClass).val();

	$.post("includes/handlers/ajax/updateEmail.php",{email:emailValue,username:userLoggedIn})
	.done(function(response){
		//trazenje itema sa klasom message posle elementa sa klasom u prvoj zagradi 
		$("." +emailClass).nextAll(".message").text(response);
	});

}
function updatePassword(oldPasswordClass,newPasswordClass1,newPasswordClass2){
	var oldPassword=$("."+ oldPasswordClass).val();
	var newPassword1=$("."+ newPasswordClass1).val();
	var newPassword2=$("."+ newPasswordClass2).val();

	$.post("includes/handlers/ajax/updatePassword.php",
		{oldPassword:oldPassword,
			newPassword1:newPassword1,
			newPassword2:newPassword2,
			username:userLoggedIn})
	.done(function(response){
		//trazenje itema sa klasom message posle elementa sa klasom u prvoj zagradi 
		$("." +oldPasswordClass).nextAll(".message").text(response);
	});

}

function logout(){
	$.post("includes/handlers/ajax/logout.php",function(){
		location.reload();
	});
}

function openPage(url){

	if(timer!=null){
		clearTimeout(timer);
	}


	//konvertuje url
		if(url.indexOf("?")==-1){
			url=url+"?";
		}
		var encodedUrl=encodeURI(url+"&userLoggedIn="+userLoggedIn);
		$("#mainContent").load(encodedUrl);
		$("body").scrollTop(0);
		//mjenja url kad idemo od stranice do stranice 
		history.pushState(null,null,url);
}

function hideOptionsMenu() {
	var menu = $(".optionsMenu");
	if(menu.css("display") != "none") {
		menu.css("display", "none");
	}
}

function showOptionsMenu(button){
	//prev all znaci da ne mora songid biti odma iznad tog buttona
	var songId=$(button).prevAll(".songId").val();
	var menu=$(".optionsMenu");
	var menuWidth=menu.width();
	//dodjeljujemo vrijednos inputa u menuOptions
	menu.find(".songId").val(songId);
	//distanse fromtop of window to top of document
	var scrollTop=$(window).scrollTop();
	//distance from top of document
	var elementOffset=$(button).offset().top;

	var top=elementOffset-scrollTop;
	var left=$(button).position().left;
	menu.css({"top":top+"px","left":left-menuWidth +"px", "display":"inline"});
}

function removeFromPlaylist(button,playlistId){
	var songId=$(button).prevAll(".songId").val();

	$.post("includes/handlers/ajax/removeFromPlaylist.php",{playlistId : playlistId,songId:songId}).done(function(error){
		//done prestavlja blok koda koji ce se izvrsiti ako se post metoda izvrsi
		if(error!=""){
			alert(error);
			return;
		}
		openPage("playlist.php?id="+playlistId);
	});
}

function createPlaylist(){
	var popup = prompt("Please enter name of your playlist");

	if(popup!=null ){
		$.post("includes/handlers/ajax/createPlaylist.php",{name:popup,username:userLoggedIn}).done(function(error){
			//done prestavlja blok koda koji ce se izvrsiti ako se post metoda izvrsi
			if(error!=""){
				alert(error);
				return;
			}
			openPage("yourMusic.php");
		});
	}
}

function deletePlaylist(playlistId){
	var prompt=confirm("Are you sure you want to delete playlist? ")
	if(prompt==true){
		$.post("includes/handlers/ajax/deletePlaylist.php",{playlistId : playlistId}).done(function(error){
			//done prestavlja blok koda koji ce se izvrsiti ako se post metoda izvrsi
			if(error!=""){
				alert(error);
				return;
			}
			openPage("yourMusic.php");
		});
	}

}

function formatTime(seconds){
	var time=Math.round(seconds);
	var minutes=Math.floor(time/60);//zaokruzuje a manju
	var seconds=time-minutes*60;//ostatak sekundi
	
	var extraZero =(seconds<10) ? "0" : "";
	return minutes+":"+extraZero+seconds;
}

function updateTimeProgressBar(audio){
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration-audio.currentTime));

	var progress=audio.currentTime/audio.duration *100;
	$(".playbackBar .progress").css("width",progress+"%");
}
function updateVolumeProgressBar(audio){
	var volume=audio.volume * 100;
	$(".volumeBar .progress").css("width",volume+"%");
}

function playFirstSong(){
	setTrack(tempPlaylist[0],tempPlaylist,true);
}

function Audio(){

	this.currentlyPlaying;
	this.audio=document.createElement('audio');

	this.audio.addEventListener('ended',function(){
		nextSong();
	});

	this.audio.addEventListener("canplay",function(){
		//this.duration se odnosi na objekat audio
		var duration=formatTime(this.duration);
		$(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener("timeupdate",function(){
		if(this.duration){
			updateTimeProgressBar(this);
		}
	});
	this.audio.addEventListener("volumechange",function(){
		updateVolumeProgressBar(this);
	});
	this.setTrack=function(track){
		this.currentlyPlaying=track;
		this.audio.src=track.path;
	}
	this.play=function(){
		this.audio.play();
	}
	this.pause=function(){
		this.audio.pause();
	}
	this.setTime=function(seconds){
		this.audio.currentTime=seconds;
	}
}