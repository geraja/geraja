$(function(){

  var page = 1;
  var typeGame = $('.game-type-item.selected').data('game-type');
  var levelGame = parseInt($('.level-items .selected').data('game-level'));
  var score = 0;
  var gameTime;

  function changePage(newPage) {
    if(newPage) {
      page = newPage;
      $('.stage .game-page').removeClass('active animated fadeIn');
      $('#game-page-' + page).addClass('active animated fadeIn');
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

    $('.game-level-options .btn-action').blur();
    $('.level-items li .btn').removeClass('selected');
    $('.level-items li').first().children('.btn').addClass('selected');
    changePage(2);

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
        page = 1;
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

    page = 1;
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
      if(typeGame === 'eyes-open') {
        $('.game-type-item:nth-of-type(2)').addClass('selected');
      } else {
        $('.game-type-item:nth-of-type(1)').addClass('selected');
      }
    } else if(keyCode == 39) {
      if(typeGame === 'eyes-close') {
        $('.game-type-item:nth-of-type(1)').addClass('selected');
      } else {
        $('.game-type-item:nth-of-type(2)').addClass('selected');
      }
    } else if(keyCode == 32) {
      typeGame = $('.game-type-item.selected').data('game-type');

      $('.game-level-options .btn-action').blur();
      $('.level-items li').first().children('.btn').addClass('selected');
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
  }

  function selectAnswer(keyCode) {
    var $levelSelected = $('.list-answers .selected').parent();

    if(keyCode == 32) {
      checkAnswer();
    } else if(keyCode == 37) {
      $('.list-answers .btn').removeClass('selected');

      if ($levelSelected.prev().length == 0) {
        $('.list-answers li').last().children('.btn').addClass('selected');
      } else {
        $levelSelected.prev().children('.btn').addClass('selected');
      }
    } else if(keyCode == 39) {
      $('.list-answers .btn').removeClass('selected');

      if ($levelSelected.next().length == 0) {
        $('.list-answers li').first().children('.btn').addClass('selected');
      } else {
        $levelSelected.next().children('.btn').addClass('selected');
      }
    }
  }

  function newGame() {
    $('.question-container').remove();
    $('.list-answers li').remove();

    var $treadmill = $('.treadmill');
    var items = ['futbol-o.svg', 'heart-o.svg', 'cloud.svg']
    var item = getRandomInt(0, items.length - 1);
    var numberItems = getRandomInt(0, 8);
    var optionsAnswers = [];

    $treadmill.append('<div class="question-container"><div class="question-items"></div><div class="question-base"></div></div>');

    var $question = $('.question-container .question-items');

    for(var i = 1; i <= numberItems; i++) {
      $question.append('<div class="question-item"><img src="../public/images/'+items[item]+'" alt="Item em movimento na esteira do jogo" width="32" height="32"></div>')
    }

    for(var n = 0; n <= 12; n++) {
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
    var hasCorrectAnswer = $('.list-answers button[data-answer="'+numberItems+'"]').length;

    if(!hasCorrectAnswer) {
      var rightAnswerPosition = getRandomInt(1, 4);
      var $buttonAnswer = $('.list-answers li:nth-child('+rightAnswerPosition+') .btn');

      $buttonAnswer.text(numberItems);
      $buttonAnswer.attr('data-answer', numberItems);
    }

    $('.question-container').addClass('question-move');

    if(gameTime) window.clearTimeout(gameTime);

    // Time that the user has for choose answer
    gameTime = window.setTimeout(function() {

      $('.wrong-answer')[0].play();
      newGame();

    }, 15600);

  }

  function checkAnswer() {
    if($('.list-answers .selected').length) {
      var answer = parseInt($('.list-answers .selected').data('answer'));
      var rightAnswer = $('.question-container .question-items img').length;

      // Clean timeout
      if(gameTime) window.clearTimeout(gameTime);

      if(answer == rightAnswer) {
        // Right answer
        $('.right-answer')[0].play();
        score++;

        var strScore = score < 10 ? '0' + score : score;
        $('.score').text(strScore);

        // Score animation
      } else {
        // Wrong answer
        $('.wrong-answer')[0].play();
      }

      if(score < 10) {
        // Start again
        newGame();
      } else {
        resetGame();

        page = 4;
        changePage(page);
      }
    }
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

  // Active/Display the first page
  $('#game-page-' + page).addClass('active animated fadeIn');
});
