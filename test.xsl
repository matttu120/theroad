<?xml version="1.0"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html>
<xsl:apply-templates/>
	<u>XMAS2012List</u>
	</html>
</xsl:template>
<xsl:template match="xmas">
<body><xsl:apply-templates/></body>
</xsl:template>
<xsl:template match="family">
<p> <xsl:value-of select="present/to"/></p><br/>
</xsl:template>
<xsl:template match="friends">
<p> <xsl:value-of select="present/to"/></p><br/>
</xsl:template>
</xsl:stylesheet>