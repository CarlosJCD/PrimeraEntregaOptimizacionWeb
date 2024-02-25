<form action="/feeds/new" method = "POST">
    <input type="text" name="url[]" placeholder="Enter the feed URL" value = '<?php echo $urls[0] ?? '' ?>' >
    <input type="text" name="url[]" placeholder="Enter the feed URL" value = '<?php echo $urls[1] ?? '' ?>' >
    <input type="text" name="url[]" placeholder="Enter the feed URL" value = '<?php echo $urls[2] ?? '' ?>' >
    <input type="text" name="url[]" placeholder="Enter the feed URL" value = '<?php echo $urls[3] ?? '' ?>' >
    <input type="text" name="url[]" placeholder="Enter the feed URL" value = '<?php echo $urls[4] ?? '' ?>' >
   
    <input type="submit" value="Add feed">
</form>

<form action="/feeds/delete/" method = "POST"> 
    <input type="submit" value="Delete feeds">
</form>
<a href="/news"><button>Noticias</button></a>