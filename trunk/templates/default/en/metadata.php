<?php $this->includeAtTemplateBase('includes/header.php'); ?>

	<div id="content">

		<h2><?php if (isset($data['header'])) { echo $data['header']; } else { echo "Some error occured"; } ?></h2>
		
		<p>Here is SAML 2.0 metadata that simpleSAMLphp has generated for you. You may send this SAML 2.0 Metadata document to trusted partners to setup a trusted federation.</p>
		
		<?php if (isset($data['metaurl'])) { ?>
			<p>You can <a href="<?php echo htmlspecialchars($data['metaurl']); ?>">get the metadata xml on a dedicated URL</a>:<br />
			<input type="text" style="width: 90%" value="<?php echo htmlspecialchars($data['metaurl']); ?>" /></p>
		<?php } ?>
		<h2>Metadata</h2>
		
		<pre style="overflow: scroll; border: 1px solid #eee; padding: 2px"><?php echo $data['metadata']; ?></pre>

		
		<?php if(array_key_exists('sendmetadatato', $this->data) { ?>
		
		
			<div style="border: 1px solid #444; margin: 2em; padding: 1em; background: #eee">
			
				<h2>Send your metadata to <?php $this->data['federationname']; ?></h2>
				
				<p>simpleSAMLphp has detected that you have configured Feide as your default IdP.</p>
				
				<p>Before you can connect to Feide, Feide needs to add your service in its trust configuration. When you
					contact Feide to add you as a new service, you will be asked to send your metadata. Here you can easily send
					the metadata to Feide by clicking the button below.</p>
					
				<form action="<?php $this->data['sendmetadatato']; ?>" method="post">

					<p>Feide needs to know how to get in contact with you, so you need to type in <strong>your email address</strong>:
						<input type="text" size="25" name="email" value="" />
					</p>
					
					<input type="hidden" name="metadata" value="<?php echo urlencode(base64_encode($data['metadata'])); ?>" />
					<input type="hidden" name="techemail" value="<?php echo $_POST['techemail']; ?>" />
					<input type="hidden" name="version" value="<?php echo $_POST['version']; ?>" />
					<input type="hidden" name="defaultidp" value="<?php echo htmlspecialchars($data['defaultidp']); ?>" />
					<input type="submit" name="send" value="Send my metadata to <?php $this->data['federationname']; ?>" />
					
				</form>
				
			</div>
		
		<?php } ?>

<?php $this->includeAtTemplateBase('includes/footer.php'); ?>