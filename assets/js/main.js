$(function(){
  var page = 1;
  var typeGame = $('.game-type-item.selected').data('game-type');

  $('.game-type-item').click(function(){
    $('.game-type-item').removeClass('selected');
    $(this).addClass('selected');
    typeGame = $(this).data('game-type');

    changePage(2);
  });

  $("body").keydown(function(e) {
    e.preventDefault();
    // keyCode 32 = space bar
    // keyCode 37 = left key
    // keyCode 39 = right key

    if(e.keyCode == 32 || e.keyCode == 37 || e.keyCode == 39) {

      if(page === 1) {
        selectTypeGame(e.keyCode);
      }
    }
  });

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
      changePage(2);
    }

    typeGame = $('.game-type-item.selected').data('game-type');
  }

  function changePage(newPage) {
    if(newPage) {
      page = newPage;
      $('.stage .game-page').removeClass('active animated fadeIn');
      $('#game-page-' + page).addClass('active animated fadeIn')
    }
  }

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


});
