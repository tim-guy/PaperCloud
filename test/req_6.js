  // goes in wordCloudPage.html
  QUnit.test("startProgressBarTest", function( assert ) {
    startProgressBar();
    assert.equal(t, 0);
  });