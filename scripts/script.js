const cards = document.querySelectorAll('.memory-card'); //Select all card elements

var stopwatch = {
    eltime : null, // holds HTML time display
    timer : null, // timer object
    now : 0, // current timer
    init : function () {
      // Get HTML elements
	  stopwatch.etime = document.getElementsByClassName("stopwatch-time")[0]; //Span element that is positioned on main page
	  stopwatch.etime_end = document.getElementsByClassName("stopwatch-time")[1]; //Span element that is positioned on win box after the player has won the game
	  stopwatch.etime_form = document.getElementsByClassName("stopwatch-time")[2]; //Hidden Input tag 
    },
  
    tick : function () {
    // tick() : update display if stopwatch running
  
      // Calculate hours, mins, seconds
      stopwatch.now++;
      var remain = stopwatch.now;
      var hours = Math.floor(remain / 3600);
      remain -= hours * 3600;
      var mins = Math.floor(remain / 60);
      remain -= mins * 60;
      var secs = remain;
  
      // Update the display timer
      if (hours<10) { hours = "0" + hours; }
      if (mins<10) { mins = "0" + mins; }
      if (secs<10) { secs = "0" + secs; }
	  stopwatch.etime.innerHTML = hours + ":" + mins + ":" + secs;
	  stopwatch.etime_end.innerHTML = hours + ":" + mins + ":" + secs;
	  stopwatch.etime_form.value = stopwatch.now;
    },
  
    start : function () {
    //start the stopwatch
      stopwatch.timer = setInterval(stopwatch.tick, 1000);
    },
  
    stop  : function () {
    // stop the stopwatch
      clearInterval(stopwatch.timer);
      stopwatch.timer = null;
    },
  
    reset : function () {
    //reset the stopwatch
      // Stop if running
      if (stopwatch.timer != null) { stopwatch.stop(); }
  
      // Reset time
      stopwatch.now = -1;
      stopwatch.tick();
    }
  };

let gameHasStarted = false; //Variable that checks if game has Started
let hasFlippedCard = false; //Variable that checks if card has been flipped
let lockBoard = false; //Variable that block clicks function on cards while card are not flipped back
let firstCard, secondCard; 
let Matches = 0; //Variable that checks the total number of matches
let winbox = document.getElementsByClassName("win-box")[0]; //Get Win-box element
let wincontent = document.getElementsByClassName("win-content")[0]; //Get win-content element


function flipCard() {
	if(!gameHasStarted)
	{
  //Starts the stopwatch if first flip is done and game has started
	stopwatch.start();
	}
  gameHasStarted = true;
	if (lockBoard) return; //If lockBoard is set to true player cannot flip other cards
	if (this === firstCard) return; //If the player clicks on the first card he has already flipped, then return
	this.classList.add('flip'); //Add class flip to element

	if (!hasFlippedCard) {
    //Checks if first card has not been flipped
	  hasFlippedCard = true;
	  firstCard = this;
	  return;
	}

	secondCard = this;

	checkForMatch();
}

function checkForMatch() {
  //Matches cards by comparing data attribute of both cards
	let isMatch = firstCard.dataset.framework === secondCard.dataset.framework;
	isMatch ? disableCards() : unflipCards(); //Check if isMatch True of False and execute either disableCards or unflipCards function
}

function disableCards() {
  //Remove click event from cards that are disabled
	firstCard.removeEventListener('click', flipCard);
	secondCard.removeEventListener('click', flipCard);
	Matches += 1; //Increase matches amount
	
	resetBoard();
}

function unflipCards() {
lockBoard = true;

setTimeout(() => {
  //Flip the cards back by removing flip class
	firstCard.classList.remove('flip'); 
	secondCard.classList.remove('flip');
	resetBoard();
}, 750);
}

function resetBoard() {
   [hasFlippedCard, lockBoard] = [false, false]; //Set these variables to be false
   [firstCard, secondCard] = [null, null]; //Set these variables to be null
   if(Matches == cardNumber / 2 ) //Check if All cards have been flipped
	{
		winbox.classList.add('on');
		wincontent.classList.add('on');
		stopwatch.stop(); //stops the stopwatch
	}
}

(function shuffle() {
   cards.forEach(card => {
     let randomPos = Math.floor(Math.random() * cardNumber);
     card.style.order = randomPos;
   });
 })();

cards.forEach(card => card.addEventListener('click', flipCard)); //Check for card click and execute flipCard function if clicked
window.addEventListener("load", stopwatch.init); //Initialize stopwatch functions after the pages is loaded