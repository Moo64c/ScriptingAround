/**
 * @file RotterNews.js
 * Created by Amir Arbel on 8/8/14.
 * Aggregate Rotter news forum to something reasonable.
 */

$(document).ready(function() {

  $('#search').on('change keyup paste', function() {
    var searchString = $('#search').val();
    $("div.news-item-wrapper:not(:contains(" + searchString + "))").hide();
    $("div.news-item-wrapper:contains('" + searchString + "')").show();
  });

  rotterRefresh();
});

Shadowbox.init({
  skipSetup:true
});

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
  var updatingImage = "style/images/updating" + (Math.floor((Math.random() * 5) + 1)).toString() + ".gif";
  var container = $("#news-container");
  var sorting = $("#sorting-options").val();
  var showTime = $("#show-time").prop("checked");
  $("#search").val("");
  // Leave an updating image in the meantime.
  container.hide(500);
  container.html('<img class="loading-gif" src="' + updatingImage + '">');
  container.show(250);

  var request = $.ajax({
    url: "RotterUpdate.php",
    type: "POST",
    data: { sorting_method: sorting },
    dataType: "html",
    error: function(data) {
      rotterRefresh();
    }
  });

  request.done(function( msg ) {
    container.html( msg );
    if (showTime) {
      jQuery("abbr.timeago").timeago();
    }
  });
}

function getFirstPost(url, id) {
  var updatingImage = "style/images/updating" + (Math.floor((Math.random() * 5) + 1)).toString() + ".gif";
  if (openNews.indexOf(id) != -1 ) {
    closeInnerContent(id);
    return;
  }
  var container = $("#content-holder-" + id);
  // Leave an updating image in the meantime.
  container.parents(".news-item").append('<img class="loading-gif loading-gif-'+id+'" src="' + updatingImage + '">');

  var request = $.ajax({
    url: "RotterUpdate.php",
    type: "POST",
    data: { firstPost: 1, url : url, id: id },
    dataType: "html",
    error: function(data, url, id) {
      getFirstPost(url,id);
    }
  });

  request.done(function( msg ) {
    container.html( msg );
    container.toggleClass("open");
    container.show(400);
    $(".loading-gif-"+id).hide();

    Shadowbox.setup("a.shadowbox-link");
  });

  openNews.push(id);
}

function closeInnerContent(id) {
  var container = $("#content-holder-" + id);
  openNews.splice(openNews.indexOf(id), 1);
  container.hide(400);
  container.toggleClass("open");
}

function applySearch(str) {
  var searchBar = $("#search");
  searchBar.val(str);
  searchBar.trigger('change');
}
