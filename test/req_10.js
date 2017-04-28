  // goes in paperListPage.html
  QUnit.test("startProgressBarTest", function( assert ) {
    $("#downloadListAsPDF").click();
    assert.equal(downloadedPDF, true);
  });