/**
 * @file RotterNews.js
 * Created by Amir Arbel on 8/8/14.
 * Aggregate Rotter news forum to something reasonable.
 */

/**
 * Allow ajax updating of Rotter news.
 */
function rotterRefresh() {
  var container = $("#news-container");
  // Leave an updating image in the meantime.
  container.html('<img src="updating.gif">');

  var request = $.ajax({
    url: "RotterUpdate.php",
//    type: "POST",
//    data: { id : menuId },
    dataType: "html"
  });

  request.done(function( msg ) {
    container.html( msg );
  });
}

// next version
// first message in topic opens at js request.
// Auto refresh rotter?

// next next version
// images from topic open into a neato frame.

//var result = $.ajax("http://rotter.net/scoopscache.html").responseXML;
//document.write(result);
