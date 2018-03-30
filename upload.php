<?php
session_start();
if($_SESSION['login']===1)
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			|->| upload |->|
		</title>
		<link rel="stylesheet" type="text/css" href="css/upload.css">

		<script>
		</script>
	</head>
	<body>
		<section>
			<header>
			<h1>upload</h1>
			</header>
			<p>welcome , <?php echo $_SESSION['username']; ?>
			<span style="float:right;margin-right:10px;"><a href="filemanager.php">File Manager</a></span>
			<span style="float:right;margin-right:10px;"><a href="download.php">Download Files</a></span>
			<span style="float:right;margin-right:10px;"><a href="index.php">Logout</a></span>

			<!--<span style="float:right;margin-right:10px;"><a href="download.php">Download File</a></span></p>-->
		</section>
		<section>
			<article>
				<form id="upload" action="uploadProcess.php" method="post" enctype="multipart/form-data">
					<fieldset>
						<legend>simple steps to upload</legend>
						<p><label for="name">Enter file Name * </label><input type="text" required name="name" id="name" placeholder="Enter" title="Avoid space between words"/></p>
						<datalist id="quest">
                        <option value="Your favourite place">
                        </option><option value="Your First School name">
                        </option><option value="Your crush name">
                        </option><option value="Your last sem roll number">
                        </option><option value="Person to whom you hate most">
						</option><option value="Thinks you fear to loose">
                         </option></datalist>
						<p><label for="question">Select Question :</label> <input name="quest" required list="quest" id="question" placeholder="if not in list specify here" />
						<p><label for="ans">Answer : </label><input type="text" required name="ans" id="ans"/></p>
						<div id="main">
						<p><label for="uploadme"><span id="custom">Select&nbsp;File</span></label><input type="file" id="uploadme" name="fileToUpload"/></p>
						<p><input type="reset"/ id="clear"></p>
						<p><input type="submit" name="submit"/></p>
						</div>
					</fieldset>
				</form>
			</article>
			<article>
				<details>
				<summary>Steps to <i><u>upload</u></i> file successfully*</summary>
				<ul>
					<li>Selet unique name to the file without any space(Eg. 'FILE_Name_1')</li>
					<li>To secure your file select question from available choice or create your own question.</li>
					<li>write answer for the same question</li>
					<li>upload your file</li>
				</ul>
				</details>
			</article>
		</section>
	</body>
</html>
<?php 
}
else
{
	echo 'You have no permission to view this page';
}
?>