  // goes in searchPage.html
  QUnit.test("startProgressBarTest", function( assert ) {
    $("#previousSearches").selectMenu();
    assert.equal(clickedPrevious, true);
  });