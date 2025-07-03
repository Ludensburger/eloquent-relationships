<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Review;

class Warhammer40kBooksSeeder extends Seeder
{
    public function run()
    {
        // Create Warhammer 40k specific genres
        $sciFiGenre = Genre::firstOrCreate(['name' => 'Science Fiction']);
        $fantasyGenre = Genre::firstOrCreate(['name' => 'Fantasy']);
        $darkSciFiGenre = Genre::firstOrCreate(['name' => 'Dark Science Fiction']);
        $militarySciFiGenre = Genre::firstOrCreate(['name' => 'Military Science Fiction']);
        $warhammerGenre = Genre::firstOrCreate(['name' => 'Warhammer 40,000']);

        // Warhammer 40k books data
        $warhammer40kBooks = [
            // Horus Heresy Series
            [
                'title' => 'Horus Rising',
                'author' => 'Dan Abnett',
                'description' => 'The first book in the Horus Heresy series. The galaxy is in flames. The Emperor\'s glorious vision for humanity is in ruins.',
                'publication_year' => 2006,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'False Gods',
                'author' => 'Graham McNeill',
                'description' => 'The second novel in the Horus Heresy series. The Great Crusade that has taken humanity into the stars continues.',
                'publication_year' => 2006,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Galaxy in Flames',
                'author' => 'Ben Counter',
                'description' => 'The third Horus Heresy novel. Having recovered from his grievous injuries, Warmaster Horus leads the triumphant Imperial forces against the rebel world of Isstvan III.',
                'publication_year' => 2006,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'The Flight of the Eisenstein',
                'author' => 'James Swallow',
                'description' => 'The fourth book in the Horus Heresy series. Having witnessed the terrible massacre on Isstvan III, Death Guard Captain Garro seizes a ship and sets a course for Terra.',
                'publication_year' => 2007,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Fulgrim',
                'author' => 'Graham McNeill',
                'description' => 'The fifth Horus Heresy novel. Under the command of the newly appointed Warmaster Horus, the Great Crusade continues.',
                'publication_year' => 2007,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ],

            // Gaunt's Ghosts Series
            [
                'title' => 'First and Only',
                'author' => 'Dan Abnett',
                'description' => 'The first Gaunt\'s Ghosts novel. On the world of Fortis Binary, Commissar Ibram Gaunt leads the Tanith First-and-Only in a desperate last stand.',
                'publication_year' => 1999,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Ghostmaker',
                'author' => 'Dan Abnett',
                'description' => 'The second Gaunt\'s Ghosts novel. On the world of Monthax, Colonel-Commissar Gaunt and his regiment fight for survival.',
                'publication_year' => 2000,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Necropolis',
                'author' => 'Dan Abnett',
                'description' => 'The third Gaunt\'s Ghosts novel. The vital hive world of Verghast teeters on the brink of destruction.',
                'publication_year' => 2000,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],

            // Eisenhorn Series
            [
                'title' => 'Xenos',
                'author' => 'Dan Abnett',
                'description' => 'The first Eisenhorn novel. Inquisitor Gregor Eisenhorn faces a vast interstellar cabal and the dark power of daemons.',
                'publication_year' => 2001,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Malleus',
                'author' => 'Dan Abnett',
                'description' => 'The second Eisenhorn novel. Inquisitor Eisenhorn is drawn into a dark conspiracy that threatens to destroy everything he has sworn to protect.',
                'publication_year' => 2001,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Hereticus',
                'author' => 'Dan Abnett',
                'description' => 'The third Eisenhorn novel. Inquisitor Eisenhorn faces his greatest challenge yet as he must confront his own fall from grace.',
                'publication_year' => 2002,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ],

            // Space Marine Battles
            [
                'title' => 'Rynn\'s World',
                'author' => 'Steve Parker',
                'description' => 'When the ork hordes of Arch-Arsonist Snagrod lay waste to the planet of Rynn\'s World, the Crimson Fists Space Marine Chapter is all but destroyed.',
                'publication_year' => 2010,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Helsreach',
                'author' => 'Aaron Dembski-Bowden',
                'description' => 'When the world of Armageddon is attacked by orks, the Black Templars Space Marine Chapter are amongst those sent to liberate it.',
                'publication_year' => 2010,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],

            // Ultramarines Series
            [
                'title' => 'Nightbringer',
                'author' => 'Graham McNeill',
                'description' => 'The first Ultramarines novel. Captain Uriel Ventris of the Ultramarines faces an ancient evil that threatens the Imperium.',
                'publication_year' => 2002,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Warriors of Ultramar',
                'author' => 'Graham McNeill',
                'description' => 'The second Ultramarines novel. Captain Uriel Ventris leads his company against the Tyranid menace.',
                'publication_year' => 2003,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],

            // Ciaphas Cain Series
            [
                'title' => 'For the Emperor',
                'author' => 'Sandy Mitchell',
                'description' => 'The first Ciaphas Cain novel. Commissar Ciaphas Cain, reluctant hero of the Imperium, is assigned to a new regiment.',
                'publication_year' => 2003,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Caves of Ice',
                'author' => 'Sandy Mitchell',
                'description' => 'The second Ciaphas Cain novel. Commissar Cain finds himself in the middle of an investigation into heretical activities.',
                'publication_year' => 2004,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],

            // Ravenor Series
            [
                'title' => 'Ravenor',
                'author' => 'Dan Abnett',
                'description' => 'The first Ravenor novel. Inquisitor Gideon Ravenor, former student of Eisenhorn, leads his team against the forces of Chaos.',
                'publication_year' => 2004,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ],

            // Dawn of War Series
            [
                'title' => 'Dawn of War: Ascension',
                'author' => 'C.S. Goto',
                'description' => 'Based on the popular Dawn of War video game. The Blood Ravens Space Marines face corruption within their own ranks.',
                'publication_year' => 2005,
                'genres' => [$sciFiGenre, $militarySciFiGenre, $warhammerGenre]
            ],

            // Standalone Novels
            [
                'title' => 'Storm of Iron',
                'author' => 'Graham McNeill',
                'description' => 'The Iron Warriors Chaos Space Marines lay siege to the Imperial fortress world of Hydra Cordatus.',
                'publication_year' => 2002,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ],
            [
                'title' => 'Dead Sky, Black Sun',
                'author' => 'Graham McNeill',
                'description' => 'Uriel Ventris and Pasanius Lysane are exiled from the Ultramarines and must survive in the Eye of Terror.',
                'publication_year' => 2004,
                'genres' => [$sciFiGenre, $darkSciFiGenre, $warhammerGenre]
            ]
        ];        // Create authors and books
        foreach ($warhammer40kBooks as $bookData) {
            // Create or get the author
            $author = Author::firstOrCreate(
                ['name' => $bookData['author']]
            );            // Create the book
            $book = Book::create([
                'title' => $bookData['title'],
                'author_id' => $author->id
            ]);

            // Attach genres
            $book->genres()->attach($bookData['genres']);

            // Create some sample reviews
            $this->createSampleReviews($book);
        }

        $this->command->info('Warhammer 40k books have been seeded successfully!');
    }
    private function createSampleReviews($book)
    {
        $reviews = [
            [
                'rating' => 5,
                'content' => 'Absolutely brilliant! The grimdark atmosphere is perfectly captured. A must-read for any 40k fan.'
            ],
            [
                'rating' => 4,
                'content' => 'Great worldbuilding and character development. Really brings the 40k universe to life.'
            ],
            [
                'rating' => 5,
                'content' => 'Epic space battles and compelling characters. This is why I love Warhammer 40k novels!'
            ],
            [
                'rating' => 4,
                'content' => 'Dark, gritty, and action-packed. Everything you\'d expect from the 41st millennium.'
            ],
            [
                'rating' => 3,
                'content' => 'Good read, though some parts felt a bit slow. Still worth it for the lore.'
            ]
        ];

        // Create 2-4 random reviews for each book
        $numReviews = rand(2, 4);
        for ($i = 0; $i < $numReviews; $i++) {
            $reviewData = $reviews[array_rand($reviews)];
            Review::create([
                'book_id' => $book->id,
                'rating' => $reviewData['rating'],
                'content' => $reviewData['content']
            ]);
        }
    }
}
