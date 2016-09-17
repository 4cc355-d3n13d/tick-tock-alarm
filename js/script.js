
	var timer_counter = -1;
	var moment_alarm;



$(function(){

	// Cache some selectors

	var clock = $('#clock'),
		alarm = clock.find('.alarm'),
		ampm = clock.find('.ampm'),
		dialog = $('#timer-dialog').parent(),
		timer_dialog = $('#timer-dialog').parent(),
		alarm_dialog = $('#alarm-dialog').parent(),
		timer_set = $('#timer-set'),
		timer_clear = $('#timer-clear'),
		alarm_set = $('#alarm-set'),
		alarm_clear = $('#alarm-clear'),
		time_is_up = $('#time-is-up').parent();

	// This will hold the number of seconds left
	// until the alarm should go off
	// var timer_counter = -1;

	// Map digits to their names (this will be an array)
	var digit_to_name = 'zero one two three four five six seven eight nine'.split(' ');

	// This object will hold the digit elements
	var digits = {};

	// Positions for the hours, minutes, and seconds
	var positions = [
		'h1', 'h2', ':', 'm1', 'm2', ':', 's1', 's2'
	];

	// Generate the digits with the needed markup,
	// and add them to the clock

	var digit_holder = clock.find('.digits');

	$.each(positions, function(){

		if(this == ':'){
			digit_holder.append('<div class="dots">');
		}
		else{

			var pos = $('<div>');

			for(var i=1; i<8; i++){
				pos.append('<span class="d' + i + '">');
			}

			// Set the digits as key:value pairs in the digits object
			digits[this] = pos;

			// Add the digit elements to the page
			digit_holder.append(pos);
		}

	});

	// Add the weekday names

	// var weekday_names = 'MON TUE WED THU FRI SAT SUN'.split(' '),
	var weekday_names = 'ПН ВТ СР ЧТ ПТ СБ ВС'.split(' '),
		weekday_holder = clock.find('.weekdays');

	$.each(weekday_names, function(){
		weekday_holder.append('<span>' + this + '</span>');
	});

	var weekdays = clock.find('.weekdays span');


	// Run a timer every second and update the clock

	(function update_time(){

		// Use moment.js to output the current time as a string
		// hh is for the hours in 12-hour format,
		// mm - minutes, ss-seconds (all with leading zeroes),
		// d is for day of week and A is for AM/PM

		var now = moment().format("HHmmssd");
/*
		digits.h1.attr('class', digit_to_name[now[0]]);
		digits.h2.attr('class', digit_to_name[now[1]]);
		digits.m1.attr('class', digit_to_name[now[2]]);
		digits.m2.attr('class', digit_to_name[now[3]]);
		digits.s1.attr('class', digit_to_name[now[4]]);
		digits.s2.attr('class', digit_to_name[now[5]]);
*/

		if (digits.h1.attr('class') != digit_to_name[now[0]]) digits.h1.attr('class', digit_to_name[now[0]]);
		if (digits.h2.attr('class') != digit_to_name[now[1]]) digits.h2.attr('class', digit_to_name[now[1]]);
		if (digits.m1.attr('class') != digit_to_name[now[2]]) digits.m1.attr('class', digit_to_name[now[2]]);
		if (digits.m2.attr('class') != digit_to_name[now[3]]) digits.m2.attr('class', digit_to_name[now[3]]);
		if (digits.s1.attr('class') != digit_to_name[now[4]]) digits.s1.attr('class', digit_to_name[now[4]]);
		if (digits.s2.attr('class') != digit_to_name[now[5]]) digits.s2.attr('class', digit_to_name[now[5]]);

		// The library returns Sunday as the first day of the week.
		// Stupid, I know. Lets shift all the days one position down, 
		// and make Sunday last

		var dow = now[6];
		dow--;
		
		// Sunday!
		if(dow < 0){
			// Make it last
			dow = 6;
		}

		// Mark the active day of the week
		// weekdays.removeClass('active').eq(dow).addClass('active');
		if ( !weekdays.eq(dow).hasClass('active') ) {
			if (dow == 0) weekdays.eq(6).removeClass('active');
			else weekdays.eq(dow-1).removeClass('active');
			weekdays.eq(dow-1).removeClass('active');
			weekdays.eq(dow).addClass('active');
		}

		// Set the am/pm text:
		// ampm.text(now[7]+now[8]);

		// -webkit-transform: scale(1.9, 1.9) rotate(42deg) translateZ(0)


		if ( moment_alarm && Math.abs(moment().diff(moment_alarm, 'minutes')) <= 1 ) {
			try{
				//$('#alarm-ring')[0].play();
				$('.video-holder').show();
				setTimeout(function(){
					player.playVideo();
				}, 150);
			}
			catch(e){}
		}




		// Is there an alarm set?

		if(timer_counter > 0){

			// Decrement the counter with one second
			timer_counter--;

			// Activate the alarm icon
			if (!alarm.hasClass('active'))
				alarm.addClass('active')
		}
		else if(timer_counter == 0){

			time_is_up.fadeIn();


/*///
				//select the first iframe that has a src that starts with "//www.youtube"
				var firstIframe = document.querySelector('iframe[src^="https://www.youtube"]');
				//get the current source
				var src = firstIframe.src;
				//update the src with "autoplay=1"
				var newSrc = src+'&autoplay=1';
				//change iframe's src
				firstIframe.src = newSrc;
/*///
// player.playVideo();


			// Play the alarm sound. This will fail
			// in browsers which don't support HTML5 audio

			try{
				$('#alarm-ring')[0].play();
				$('.video-holder').show();
				player.playVideo();
			}
			catch(e){}
			
			timer_counter--;
			alarm.removeClass('active');
		}
		else{
			// The alarm has been cleared
			if (!moment_alarm && alarm.hasClass('active'))
				alarm.removeClass('active');
		}

		// Schedule this function to be run again in 1 sec
		setTimeout(update_time, 1000);

	})();
	// $('#clock').attr('style', '-webkit-transform: scale(1.9, 1.9) rotate(42deg) translateZ(0)');
	// $('#clock').css('-webkit-transform', 'scale(1.9, 1.9) rotate(42deg) translateZ(0)');


	// Switch the theme

	$('.switch-theme').click(function(){
		clock.toggleClass('light dark');
	});


	// Handle setting and clearing alamrs

	$('.timer-button').click(function(){
		
		// Show the dialog
		timer_dialog.trigger('show');

	});


	// Handle setting and clearing timer

	$('.alarm-button').click(function(){
		
		// Show the dialog
		alarm_dialog.trigger('show');

	});

	timer_dialog.find('.close').click(function(){
		timer_dialog.trigger('hide')
	});

	alarm_dialog.find('.close').click(function(){
		alarm_dialog.trigger('hide')
	});

	timer_dialog.click(function(e){

		// When the overlay is clicked, 
		// hide the dialog.

		if($(e.target).is('.overlay')){
			// This check is need to prevent
			// bubbled up events from hiding the dialog
			timer_dialog.trigger('hide');
		}
	});

	alarm_dialog.click(function(e){

		// When the overlay is clicked, 
		// hide the dialog.

		if($(e.target).is('.overlay')){
			// This check is need to prevent
			// bubbled up events from hiding the dialog
			alarm_dialog.trigger('hide');
		}
	});




	alarm_clear.click(function(){
		moment_alarm = false;

		alarm.removeClass('active');
	});


	alarm_set.click(function(){

		var valid = true;

		var hours = $('#alarm-dialog').parent().find('input[name=hours]')[0];
		var minutes = $('#alarm-dialog').parent().find('input[name=minutes]')[0];

		if (hours.validity && !hours.validity.valid) {
			valid = false;
			hours.focus();
			return false;
		}
		if (minutes.validity && !minutes.validity.valid) {
			valid = false;
			minutes.focus();
			return false;
		}

		// moment_alarm = moment({hour: parseInt(hours.value), minute: parseInt(minutes.value)});
		moment_alarm = moment().hours(parseInt(hours.value)).minutes(parseInt(minutes.value)).seconds(0);

		// Activate the alarm icon
		alarm.addClass('active');


		alarm_dialog.trigger('hide');


/*
		if ( $('#alarm-dialog').parent().find('input[name=hours]') )

		alarm_dialog.find('input').each(function(i){

			// Using the validity property in HTML5-enabled browsers:

			if(this.validity && !this.validity.valid){

				// The input field contains something other than a digit,
				// or a number less than the min value

				valid = false;
				this.focus();

			}

			alarm_time += parseInt(parseInt(this.value)) + ':';
			after += to_seconds[i] * parseInt(parseInt(this.value));
		});

*/



		// alarm_dialog.trigger('hide');

/*
		if(!valid){
			alert('Please enter a valid number!');
			return;
		}

		if(after < 1){
			alert('Please choose a time in the future!');
			return;	
		}

		timer_counter = after;
*/

		
	});



	timer_set.click(function(){

		var valid = true, after = 0,
			to_seconds = [3600, 60, 1];

		timer_dialog.find('input').each(function(i){

			// Using the validity property in HTML5-enabled browsers:

			if(this.validity && !this.validity.valid){

				// The input field contains something other than a digit,
				// or a number less than the min value

				valid = false;
				this.focus();

				return false;
			}

			after += to_seconds[i] * parseInt(parseInt(this.value));
		});

		if(!valid){
			alert('Please enter a valid number!');
			return;
		}

		if(after < 1){
			alert('Please choose a time in the future!');
			return;	
		}

		timer_counter = after;
		timer_dialog.trigger('hide');
	});





	timer_clear.click(function(){
		timer_counter = -1;

		timer_dialog.trigger('hide');
	});







	setInterval(function(){


		if ( moment_alarm && Math.abs(moment().diff(moment_alarm, 'minutes') <= 1) ) {
			console.log(
				' [Alarm]  ' + 
					'Minutes left: ' + Math.abs(moment().diff(moment_alarm, 'minutes')) + 'm; ' + 
					'Seconds left: ' + Math.abs(moment().diff(moment_alarm, 'seconds')) + 's; ' + 
			'');
		// 	console.log ( '===-------------------------------------===' );
		}



		// Calculate how much time is left for the alarm to go off.
		var hours = 0, minutes = 0, seconds = 0, tmp = 0;
		if (timer_counter > 0) {
			// There is an alarm set, calculate the remaining time
			tmp = timer_counter;
			hours = Math.floor(tmp/3600);
			tmp = tmp%3600;
			minutes = Math.floor(tmp/60);
			tmp = tmp%60;
			seconds = tmp;

			// Update the input fields
			timer_dialog.find('input')
			.eq(0).val(hours < 10 ? '0' + hours:hours).end()
			.eq(1).val(minutes < 10 ? '0' + minutes:minutes).end()
			.eq(2).val(seconds < 10 ? '0' + seconds:seconds);
		}
	}, 1000);





	// Custom events to keep the code clean
	alarm_dialog.on('hide',function(){

		alarm_dialog.fadeOut();

	}).on('show',function(){

		// Calculate how much time is left for the alarm to go off.

		var hours = 0, minutes = 0, seconds = 0, tmp = 0;

		if (timer_counter > 0) {
			
			// There is an alarm set, calculate the remaining time

			tmp = timer_counter;

			hours = Math.floor(tmp/3600);
			tmp = tmp%3600;

			minutes = Math.floor(tmp/60);
			tmp = tmp%60;

			seconds = tmp;
		}

		// Update the input fields
		timer_dialog.find('input')
			.eq(0).val(hours < 10 ? '0' + hours:hours).end()
			.eq(1).val(minutes < 10 ? '0' + minutes:minutes).end()
			.eq(2).val(seconds < 10 ? '0' + seconds:seconds);

		alarm_dialog.fadeIn();

	});

	// Custom events to keep the code clean
	timer_dialog.on('hide',function(){

		timer_dialog.fadeOut();

	}).on('show', function(){

		// Calculate how much time is left for the alarm to go off.

		var hours = 0, minutes = 0, seconds = 0, tmp = 0;

		if(timer_counter > 0){
			
			// There is an alarm set, calculate the remaining time

			tmp = timer_counter;

			hours = Math.floor(tmp/3600);
			tmp = tmp%3600;

			minutes = Math.floor(tmp/60);
			tmp = tmp%60;

			seconds = tmp;
		}

		// Update the input fields
		timer_dialog.find('input')
			.eq(0).val(hours < 10 ? '0' + hours:hours).end()
			.eq(1).val(minutes < 10 ? '0' + minutes:minutes).end()
			.eq(2).val(seconds < 10 ? '0' + seconds:seconds);

		timer_dialog.fadeIn();

	});

	time_is_up.click(function(){
		time_is_up.fadeOut();
	});

});