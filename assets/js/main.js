$(function(){
  var page = 1;
  var typeGame = $('.game-type-item.selected').data('game-type');
  var levelGame = parseInt($('.level-items .selected').data('game-level'));

  function changePage(newPage) {
    if(newPage) {
      page = newPage;
      $('.stage .game-page').removeClass('active animated fadeIn');
      $('#game-page-' + page).addClass('active animated fadeIn')
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

      } else if(page == 4) {

      }
    }
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

});
