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

/**
 * Maschinebox.io Machinebox-Test
 */
final class ClassificationboxTest extends TestCase {
	
	public function test1() {
		try {
			$box = new \machinebox\classificationbox("http://127.0.0.1:8081");
			$box->createmodel("sprache01", "Spracherkennung", array("english","deutsch"));

			$box->usemodel("sprache01");

			$input = new inputlist();
			$input->add("text", "Hallo dies ist ein deutscher Satz.");
			$box->teach("deutsch", $input);


			$input = new inputlist();
			$input->add("text", "Hello, this is an english sentence.");
			$box->teach("english", $input);

			$input = new inputlist();
			$input->add("text", "Welche Sprache hat dieser Satz?");
			$out = $box->predict($input);
			$this->assertTrue(true);
		} catch (\Exception $ex) {
			$this->assertTrue(false);
		}
	}
	
}