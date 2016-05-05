<!DOCTYPE html>
<!-- saved from url=(0043)http://ludo.cubicphuse.nl/jquery-treetable/ -->
<html>

  
  <body>
  
  <div> PYJ </div>
  
    <link rel="stylesheet" href="../common/assets/treetable/screen.css" media="screen">
    <link rel="stylesheet" href="../common/assets/treetable/jquery.treetable.css">
    <link rel="stylesheet" href="../common/assets/treetable/jquery.treetable.theme.default.css">
    <script async="" src="../common/assets/treetable/analytics.js"></script><script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-184215-9', 'cubicphuse.nl');
      ga('send', 'pageview');
    
    </script>
    
    <div id="main">
      
      <table id="example-basic" class="treetable">
        <caption>Basic jQuery treetable Example
        
          <a href="http://ludo.cubicphuse.nl/jquery-treetable/#" onclick="jQuery(&#39;#example-basic&#39;).treetable(&#39;expandAll&#39;); return false;">Expand all</a>
          <a href="http://ludo.cubicphuse.nl/jquery-treetable/#" onclick="jQuery(&#39;#example-basic&#39;).treetable(&#39;collapseAll&#39;); return false;">Collapse all</a>
        
        </caption>
        <thead>
          <tr>
            <th>Tree column</th>
            <th>Additional data</th>
          </tr>
        </thead>
        <tbody>
          <tr data-tt-id="1" class="branch collapsed">
            <td><span class="indenter" style="padding-left: 0px;"></span>Node 1: Click on the icon in front of me to expand this branch.</td>
            <td>I live in the second column.</td>
          </tr>
          <tr data-tt-id="1.1" data-tt-parent-id="1" class="branch" style="display: none;">
            <td><span class="indenter"></span>Node 1.1: Look, I am a table row <em>and</em> I am part of a tree!</td>
            <td>Interesting.</td>
          </tr>
          <tr data-tt-id="1.2" data-tt-parent-id="1" class="leaf" style="display: none;">
            <td><span class="indenter"></span>Node 1.1.1: I am part of the tree too!</td>
            <td>That's it!</td>
          </tr>
          <tr data-tt-id="2" class="leaf collapsed">
            <td><span class="indenter" style="padding-left: 0px;"></span>Node 2: I am another root node, but without children</td>
            <td>Hurray!</td>
          </tr>
        </tbody>
      </table>

    </div>

    <script src="../common/assets/treetable/jquery.js"></script>
    <script src="../common/assets/treetable/jquery.ui.core.js"></script>
    <script src="../common/assets/treetable/jquery.ui.widget.js"></script>
    <script src="../common/assets/treetable/jquery.ui.mouse.js"></script>
    <script src="../common/assets/treetable/jquery.ui.draggable.js"></script>
    <script src="../common/assets/treetable/jquery.ui.droppable.js"></script>
    <script src="../common/assets/treetable/jquery.treetable.js"></script>
    <script>
      $("#example-basic").treetable({ expandable: true });   

    
    </script>
  

</body></html>
