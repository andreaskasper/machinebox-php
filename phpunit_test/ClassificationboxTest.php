<?php
/**
 *
 *
 *
 *
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
namespace machinebox\Test;

use PHPUnit\Framework\TestCase;
use machinebox\inputlist;


/**
 * Maschinebox.io Machinebox-Test
 */
final class ClassificationboxTest extends TestCase {
	
	public function test1() {
			$box = new \machinebox\classificationbox("http://127.0.0.1:8081");
			$box->verbose = true;
			$r = $box->createmodel("sprache01", "Spracherkennung", array("english","deutsch"));
			$this->assertTrue($r);
			
			$r = $box->listmodels();
			$this->assertHasKey("sprache01", $r);
			$this->assertCount(1, $r); //1 Ergebnis

			$box->usemodel("sprache01");

			$input = new inputlist();
			$input->add("text", "Hallo dies ist ein deutscher Satz.");
			$r = $box->teach("deutsch", $input);
			$this->assertTrue($r);

			$input = new inputlist();
			$input->add("text", "Hello, this is an english sentence.");
			$r = $box->teach("english", $input);
			$this->assertTrue($r);

			$input = new inputlist();
			$input->add("text", "Welche Sprache hat dieser Satz?");
			$out = $box->predict($input);
			
			$this->assertCount(2, $out); //2 Ergebnisse
			
			$r = $box->deletemodel("sprache01");
			$this->assertTrue($r);
			
			$this->assertTrue(true);
	}
	
}
