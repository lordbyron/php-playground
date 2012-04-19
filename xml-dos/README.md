xml-dos
=======

Building a PHP webapp with an XML API, and need to make sure it's not susceptible to any DOS attacks

1. Local File Inclusion
2. Exponential Entity Blowup (Billion Laughs)
3. Quadratic Entity Blowup <-- hardest

http://stackoverflow.com/questions/10212752/how-can-i-use-phps-various-xml-libraries-to-get-dom-like-functionality-and-avoi
http://msdn.microsoft.com/en-us/magazine/ee335713.aspx

Findings:
1. disable local file inclusion with libxml_disable_entity_loader();
2. by default, libxml won't allow much entity recursion
3. This is the real challenge. I found the most surefire solution was to simply disallow any inline DTDs in the API. See parse.php function preparse.
