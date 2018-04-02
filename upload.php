<?php
session_start();
if($_SESSION['login']===1)
{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Upload Files to you Cloud Storage  - ICSSICs
		</title>
		<link rel="stylesheet" type="text/css" href="css/upload.css">
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>


		<script>
		</script>
	</head>
	<body>
		<section>
			<header>
			<h1>Upload your files</h1>
			</header>
			<p>Welcome, <?php echo $_SESSION['username']; ?>
			<span style="float:right;margin-right:10px;"><a href="access.php">Logout</a></span>
			<span style="float:right;margin-right:10px;"><a href="download.php">Download Files</a></span>
			<span style="float:right;margin-right:10px;"><a href="filemanager.php">File Manager</a></span>
</p>
			<!--<span style="float:right;margin-right:10px;"><a href="download.php">Download File</a></span></p>-->
		</section>
		<section>
			<article>
				<form id="upload" action="uploadProcess.php" method="post" enctype="multipart/form-data">
					<fieldset>
						<legend><h3>select a file</h3></legend>
						<p id=formentry><label for="name"></label>
						<input type="text" required name="name" id="name" placeholder="Enter a File Name*" title="Avoid Spaces"/></p>
						<datalist id="quest">
                        <option value="Your favourite place">
                        </option><option value="Your First School name">
                        </option><option value="Your crush name">
                        </option><option value="Your last sem roll number">
                        </option><option value="Person to whom you hate most">
						</option><option value="Thinks you fear to loose">
                         </option></datalist>
						<p id=formentry>
						<label for="question"></label>
						 <input name="quest" required list="quest" id="question" placeholder="Select a question or create a custom" />
						<p id=formentry>
						<label for="ans"></label>
						<input type="text" required name="ans" placeholder="Answer*" id="ans"/></p>
						<div id="main"><br/>
						<p><label for="uploadme"><span id="custom">Select&nbsp;File</span></label><input type="file" id="uploadme" name="fileToUpload"/></p>
						<p><input type="Reset" id="clear"></p>
						<p><input type="Submit" name="submit"/></p>
						</div>
					</fieldset>
				</form>
			</article>
			<article>
				<details>
				<summary>Steps to <i><u>upload</u></i> a file successfully*</summary>
				<ul>
					<li>Selet unique name to the file without any space(Eg. 'FILE_Name_1')</li>
					<li>To secure your file select question from available choice or create your own question.</li>
					<li>Write answer for the same question</li>
					<li>Upload your file</li>
				</ul>
				</details>
			</article>
		</section>
        
            	<footer class="footer-basic-centered">

			<p class="footer-company-motto">&copy 2018 - Made with <span><i class="fas fa-heart"> </i></span> at VESIT

</p>
		
        </footer>
	</body>
</html>

<?php 
}
else
{
	echo 'You have no permission to view this page';
}
?>