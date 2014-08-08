/**
 * @file RotterNews.js
 * Created by Amir Arbel on 8/8/14.
 * Aggregate Rotter news forum to something reasonable.
 */

$(function () {
  $(document).keydown(function (e) {
    if (e.keyCode == 116) {
      rotterRefresh();
    }

    return (e.which || e.keyCode) != 116;
  });
});

// Hold information what news items are open.
var openNews = [];

/**
 * Allow ajax updating of Rotter news.
 */
function rotterRefresh() {
  var container = $("#news-container");
  // Leave an updating image in the meantime.
  container.hide(600);
  container.html('<img src="updating.gif">');
  container.show(600);

  var request = $.ajax({
    url: "RotterUpdate.php",
    dataType: "html"
  });

  request.done(function( msg ) {
    container.html( msg );
  });
}

function getFirstPost(url, id) {
  if (openNews.indexOf(id) != -1 ) {
    closeInnerContent(id);
    return;
  }
  var container = $("#content-holder-" + id);
  // Leave an updating image in the meantime.
  container.parents(".news-item").append('<img class="loadingGif-'+id+'" src="updating.gif">');

  var request = $.ajax({
    url: "RotterUpdate.php",
    type: "POST",
    data: { firstPost: 1, url : url, id: id},
    dataType: "html"
  });

  request.done(function( msg ) {
    container.html( msg );
    container.show(400);
    $(".loadingGif-"+id).hide();
  });

  openNews.push(id);
}

function openInNewWindow(url) {
  var win = window.open(url, '_blank');
  win.focus();
}

function closeInnerContent(id) {
  var container = $("#content-holder-" + id);
  openNews.splice(openNews.indexOf(id), 1);
  container.hide(400);
}

// next version
// Auto refresh rotter
// images from topic open into a neato frame.
