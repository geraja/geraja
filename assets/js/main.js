$(function(){

  var page = 2;
  var typeGame = $('.game-type-item.selected').data('game-type');
  var levelGame = parseInt($('.level-items .selected').data('game-level'));
  var score = 0;
  var numberItems = 0;
  var gameTime;
  var audios;
  var audiosLoaded = 0;
  var totalAudios = 0;
  var audioPlayer = document.getElementById('audio-player');

  function changePage(newPage) {
    if(newPage) {
      page = newPage;
      $('.stage .game-page').removeClass('active animated fadeIn');
      $('#game-page-' + page).addClass('active animated fadeIn');

      if(page == 1) {
        playAudio('selecione-modo-jogo');
      } else if(page == 2) {
        if(typeGame == 'audio-version') {
          playAudio('selecione-dificuldade-jogo');
        }
      }
    }
  }

  /*
  |--------------------------------------------------------------------
  | Click and keydown handlers
  |--------------------------------------------------------------------
  */
  $('.back-page').click(function(){
    $(this).blur(); // remove focus of the element/button

    page--;
    changePage(page);
  });

  $('.next-page').click(function(){
    $(this).blur(); // remove focus of the element/button

    page++;
    changePage(page);
  });

  $('.game-type-item').click(function(){
    $('.game-type-item').removeClass('selected');
    $(this).addClass('selected');
    typeGame = $(this).data('game-type');
  });

  $('.btn-level').click(function(){
    $('.btn-level').removeClass('selected');
    $(this).addClass('selected');
  });

  $("body").keydown(function(e) {
    e.preventDefault();
    // keyCode 32 = space bar
    // keyCode 37 = left key
    // keyCode 39 = right key

    if(e.keyCode == 32 || e.keyCode == 37 || e.keyCode == 39) {
      if(page == 1) {
        selectTypeGame(e.keyCode);
      } else if(page == 2) {
        selectLevelGame(e.keyCode);
      } else if(page == 3) {
        selectAnswer(e.keyCode);
      } else if(page == 4) {
        page = 2;
        changePage(page);
      }
    }
  });

  $('.list-answers').on('click', '.btn', function(){
    $('.list-answers li .btn').removeClass('selected');
    $(this).addClass('selected');
  });

  $('#game-page-4 .btn-action').click(function(){
    $(this).blur(); // remove focus of the element/button

    page = 2;
    changePage(page);
  });

  /*
  |--------------------------------------------------------------------
  | Game config and navigation functions
  |--------------------------------------------------------------------
  */
  function selectTypeGame(keyCode) {
    if(keyCode == 37 || keyCode == 39) {
      typeGame = $('.game-type-item.selected').data('game-type');
      $('.game-type-item').removeClass('selected');
    }

    if(keyCode == 37) {
      if(typeGame == 'vison-version') {
        playAudio('jogar-ouvindo');
        $('.game-type-item:nth-of-type(2)').addClass('selected');
      } else {
        playAudio('jogar-vendo');
        $('.game-type-item:nth-of-type(1)').addClass('selected');
      }
    } else if(keyCode == 39) {
      if(typeGame == 'audio-version') {
        playAudio('jogar-vendo');
        $('.game-type-item:nth-of-type(1)').addClass('selected');
      } else {
        playAudio('jogar-ouvindo');
        $('.game-type-item:nth-of-type(2)').addClass('selected');
      }
    } else if(keyCode == 32) {
      typeGame = $('.game-type-item.selected').data('game-type');

      $('.game-level-options .btn-action').blur();
      $('.level-items li .btn').removeClass('selected');
      $('.level-items li').first().children('.btn').addClass('selected');

      if(typeGame == 'audio-version') {
        playAudio('selecione-dificuldade-jogo');
      }

      changePage(2);
    }

    typeGame = $('.game-type-item.selected').data('game-type');
  }

  function selectLevelGame(keyCode) {

    if(keyCode == 32) {
      if($('.level-items .selected').length) {

        levelGame = parseInt($('.level-items .selected').data('game-level'));
        changePage(3);

        $('.level-items .btn').removeClass('selected');
        $('.level-items li').first().children('.btn').addClass('selected');

        newGame();
      }
    } else if(keyCode == 37) {
      if($('.level-items .selected').length == 0) {
        $('.game-level-options .btn-action').blur();
        $('.level-items li').last().children('.btn').addClass('selected');
      } else {
        var $levelSelected = $('.level-items .selected').parent();

        $('.level-items .btn').removeClass('selected');

        if ($levelSelected.prev().length == 0) {
          $('.game-level-options .btn-action').focus();
        } else {
          $levelSelected.prev().children('.btn').addClass('selected');
        }
      }
    } else if(keyCode == 39) {
      if($('.level-items .selected').length == 0) {
        $('.game-level-options .btn-action').blur();
        $('.level-items li').first().children('.btn').addClass('selected');
      } else {
        var $levelSelected = $('.level-items .selected').parent();
        $('.level-items .btn').removeClass('selected');

        if ($levelSelected.next().length == 0) {
          $('.game-level-options .btn-action').focus();
        } else {
          $levelSelected.next().children('.btn').addClass('selected');
        }
      }
    }

    if(keyCode == 37 || keyCode == 39) {
      levelGame = $('.level-items .selected').data('game-level');

      if(typeGame == 'audio-version') {
        if(levelGame) {
          playAudio('numero-' + levelGame);
        }
      }
    }
  }

  function selectAnswer(keyCode) {
    var $answerSelected = $('.list-answers .selected').parent();

    if(keyCode == 32) {
      checkAnswer();
    } else if(keyCode == 37) {
      $('.list-answers .btn').removeClass('selected');

      if ($answerSelected.prev().length == 0) {
        $('.list-answers li').last().children('.btn').addClass('selected');
      } else {
        $answerSelected.prev().children('.btn').addClass('selected');
      }
    } else if(keyCode == 39) {
      $('.list-answers .btn').removeClass('selected');

      if ($answerSelected.next().length == 0) {
        $('.list-answers li').first().children('.btn').addClass('selected');
      } else {
        $answerSelected.next().children('.btn').addClass('selected');
      }
    }

    if(keyCode == 37 || keyCode == 39) {
      if(typeGame == 'audio-version') {
        var answer = parseInt($('.list-answers .selected').data('answer'));
        playAudio('numero-' + answer);
      }
    }
  }

  function newGame() {
    $('.container').removeClass('vison-version-game');
    $('.container').removeClass('audio-version-game');



    if(typeGame == 'audio-version') {
      $('.container').addClass(typeGame + '-game');
    }

    $('.question-container').remove();
    $('.list-answers li').remove();

    if(gameTime) {
      window.clearTimeout(gameTime);
    }

    var $treadmill = $('.treadmill');
    var items;
    var item;

    numberItems = getRandomInt(0, 8);

    if(typeGame == 'audio-version') {
      $treadmill.hide();
      numberItems = getRandomInt(1, 9);

      items = sounds;
      item = getRandomInt(0, items.length - 1);

      var played = 0;

      function playAudioQuestion() {
        audioPlayer.src = audios[items[item]];
        audioPlayer.play();
        audioPlayer.addEventListener('ended', audioQuestionHandler, false);
      }

      playAudioQuestion();

      function audioQuestionHandler() {
        played++;

        if(played >= numberItems) {

          audioPlayer.removeEventListener('ended', audioQuestionHandler, false);

          $('.clock-tick')[0].play();

          createOptionsAnswers(numberItems);

          // Time that the user has for choose answer
          gameTime = window.setTimeout(function() {
            playAudio('wrong-answer');

            $('.clock-tick')[0].pause();
            $('.clock-tick').prop('currentTime', 0);

            handleNewGameTime();
          }, 13100);

        } else {
          audioPlayer.removeEventListener('ended', audioQuestionHandler, false);
          playAudioQuestion();
        }
      }

    } else {
      $treadmill.show();

      items = images;
      item = getRandomInt(0, items.length - 1);

      $treadmill.append('<div class="question-container"><div class="question-items"></div><div class="question-base"></div></div>');

      var $question = $('.question-container .question-items');

      for(var i = 1; i <= numberItems; i++) {
        $question.append('<div class="question-item"><img src="'+urlAssets+items[item]+'" alt="Item em movimento na esteira do jogo" width="32" height="32"></div>')
      }

      $('.question-container').addClass('question-move');
      createOptionsAnswers(numberItems);

      // Time that the user has for choose answer
      gameTime = window.setTimeout(function() {

        playAudio('wrong-answer');
        newGame();

      }, 15600);
    }
  }

  function createOptionsAnswers(_numberItems) {
    var rightAnswer = _numberItems;
    var optionsAnswers = [];
    for(var n = 0; n <= 10; n++) {
      optionsAnswers[n] = n;
    }

    optionsAnswers.sort(function () { return Math.random() - 0.5; });

    // Create the options of answers
    for(var a = 1; a <= 4; a++) {
      var valueAnswer = optionsAnswers[a];
      var selectedAnswer = a == 1 ? 'selected' : '';

      $('.list-answers').append('<li><button type="button" class="btn btn-answer ' + selectedAnswer + ' animated fadeInUp" data-answer="' + valueAnswer + '">' + valueAnswer + '</button></li>');
    }

    // Check if the options answers has a correct answer
    var hasCorrectAnswer = $('.list-answers button[data-answer="'+rightAnswer+'"]').length;

    if(!hasCorrectAnswer) {
      var rightAnswerPosition = getRandomInt(1, 4);
      var $buttonAnswer = $('.list-answers li:nth-child('+rightAnswerPosition+') .btn');

      $buttonAnswer.text(rightAnswer);
      $buttonAnswer.attr('data-answer', rightAnswer);
    }
  }

  function checkAnswer() {
    if($('.list-answers .selected').length) {
      var answer = parseInt($('.list-answers .selected').data('answer'));
      var rightAnswer = numberItems;

      if(typeGame == 'audio-version') {
        $('.clock-tick')[0].pause();
        $('.clock-tick').prop('currentTime', 0);
      }

      // Clean timeout
      if(gameTime) window.clearTimeout(gameTime);

      $('.list-answers li').remove();

      if(answer == rightAnswer) {
        // Right answer
        playAudio('right-answer');
        score++;

        var strScore = score < 10 ? '0' + score : score;
        $('.score').text(strScore);

        // Score animation
      } else {
        // Wrong answer
        playAudio('wrong-answer');
      }

      if(score < 10) {
        if(typeGame == 'audio-version') {
          handleNewGameTime();
        } else {
          newGame();
        }
      } else {
        resetGame();

        page = 4;
        changePage(page);

        if(typeGame == 'audio-version') {
          $('.muito-bem')[0].play();
        }
      }
    }
  }

  function handleNewGameTime() {
    window.setTimeout(newGame, 2000);
  }

  function resetGame() {
    score = 0;
    $('.score').text('00');

    $('.question-container').remove();
    $('.list-answers li').remove();

    if(gameTime) window.clearTimeout(gameTime);
  }

  function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min) + min);
  }

   /*
  |--------------------------------------------------------------------
  | Preloader to load important assets
  |--------------------------------------------------------------------
  */

  //'jogar-ouvindo': '../public/sounds/jogar-ouvindo.mp3',
  //'jogar-vendo': '../public/sounds/jogar-vendo.mp3',
  //'selecione-modo-jogo': '../public/sounds/selecione-modo-jogo.mp3',
  //'passou-nivel': '../public/sounds/voce-passou-nivel.mp3',

  audios = {
    'right-answer': '../public/sounds/right-answer.mp3',
    'wrong-answer': '../public/sounds/wrong-answer.mp3',
    'clock-tick': '../public/sounds/clock-tick-v1.mp3',
    'jogar-novamente': '../public/sounds/jogar-novamente.mp3',
    'muito-bem': '../public/sounds/muito-bem.mp3',
    'numero-0': '../public/sounds/numero-0.mp3',
    'numero-1': '../public/sounds/numero-1.mp3',
    'numero-2': '../public/sounds/numero-2.mp3',
    'numero-3': '../public/sounds/numero-3.mp3',
    'numero-4': '../public/sounds/numero-4.mp3',
    'numero-5': '../public/sounds/numero-5.mp3',
    'numero-6': '../public/sounds/numero-6.mp3',
    'numero-7': '../public/sounds/numero-7.mp3',
    'numero-8': '../public/sounds/numero-8.mp3',
    'numero-9': '../public/sounds/numero-9.mp3',
    'numero-10': '../public/sounds/numero-10.mp3',
    'selecione-dificuldade-jogo': '../public/sounds/selecione-dificuldade-jogo.mp3'
  };

  if(typeGame == 'audio-version') {
    var totalsoundsAssets = Object.keys(soundsAssets).length;

    if(totalsoundsAssets) {
      $.extend(audios, soundsAssets);
    }
  }

  totalAudios = Object.keys(audios).length;

  var preloadControl = [];

  for (var i in audios) {
    if(audios[i]) {
      preloadControl.push(audios[i])
    }
  }

  function preloadAudio(url) {
    var audio = new Audio();
    audio.addEventListener('canplaythrough', loadedAudio);
    audio.src = url;
  }

  function loadedAudio() {
    audiosLoaded++;

    if (audiosLoaded >= totalAudios) {
      init();
      $('.preloader-bar').css('width',  "0%");
    } else {
      preloadAudio(preloadControl[audiosLoaded]);
    }

    var progress = (audiosLoaded * 100) / totalAudios;
    $('.preloader-bar').css('width',  progress + "%");
  }

  function playAudio(key) {
    $('audio.playing').each(function () {
     $(this)[0].pause();
     $(this).prop('currentTime', 0);
   });

    $('audio').removeClass('playing');

    if(audios[key]) {
      $('.' + key)[0].play();
      $('.' + key).addClass('playing');
    }
  }

  function init() {
    // Active/Display the first page
    $('.game-page').removeClass('active');
    $('#game-page-' + page).addClass('active animated fadeIn');

    if(typeGame == 'audio-version') {
      playAudio('selecione-dificuldade-jogo');
    }
  }

  // preloading the audio files
  preloadAudio(preloadControl[audiosLoaded]);
});
