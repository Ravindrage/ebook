  
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>'Hello, world!' example</title>
</head>
<body>

<h1>'Hello, world!' example</h1>

<canvas id="the-canvas" style="border: 1px solid black; direction: ltr;"></canvas>

<script src="../../node_modules/pdfjs-dist/build/pdf.js"></script>

<script id="script">
  //
  // If absolute URL from the remote server is provided, configure the CORS
  // header on that server.
  //
  var url = './helloworld.pdf';

  //
  // The workerSrc property shall be specified.
  //
  pdfjsLib.GlobalWorkerOptions.workerSrc =
    '../../node_modules/pdfjs-dist/build/pdf.worker.js';

  //
  // Asynchronous download PDF
  //
  var loadingTask = pdfjsLib.getDocument(url);
  loadingTask.promise.then(function(pdf) {
    //
    // Fetch the first page
    //
    pdf.getPage(1).then(function(page) {
      var scale = 1.5;
      var viewport = page.getViewport({ scale: scale, });

      //
      // Prepare canvas using PDF page dimensions
      //
      var canvas = document.getElementById('the-canvas');
      var context = canvas.getContext('2d');
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      //
      // Render PDF page into canvas context
      //
      var renderContext = {
        canvasContext: context,
        viewport: viewport,
      };
      page.render(renderContext);
    });
  });
</script>

<hr>
<h2>JavaScript code:</h2>
<pre id="code"></pre>
<script>
  document.getElementById('code').textContent =
      document.getElementById('script').text;
</script>
</body>
</html>