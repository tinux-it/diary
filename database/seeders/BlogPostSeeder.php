<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the main user account for your friend
        $user = User::create([
            'name' => 'Dagboek Gebruiker',
            'email' => 'dagboek@example.com',
            'password' => Hash::make('dagboek123'),
            'email_verified_at' => now(),
        ]);

        // Create a private post (not shown on home page)
        BlogPost::create([
            'user_id' => $user->id,
            'subject' => 'Mijn Eerste Dagboek Entry',
            'content' => '<p>Dit is mijn eerste dagboek entry. Vandaag voel ik me een beetje onzeker over alles wat er gebeurt, maar ik probeer positief te blijven.</p><p>Het is belangrijk om te onthouden dat elke dag een nieuwe kans is. Ik ben dankbaar voor de mensen om me heen die me steunen in deze moeilijke tijd.</p><p>Morgen ga ik proberen om wat meer te bewegen en gezond te eten. Kleine stappen, maar elke stap telt.</p>',
            'date' => now('Europe/Amsterdam')->subDays(2),
            'state' => 'published',
            'is_visible' => false, // Private post
        ]);

        // Create a public post (shown on home page)
        BlogPost::create([
            'user_id' => $user->id,
            'subject' => 'Gedachten over Vandaag',
            'content' => '<p>Vandaag was een mooie dag. De zon scheen en ik voelde me wat sterker dan gisteren. Het is verbazingwekkend hoe kleine dingen je dag kunnen maken of breken.</p><p>Ik heb vandaag een wandeling gemaakt in het park en het was heerlijk om de natuur te zien. De bomen waren groen en de vogels zongen. Het herinnerde me eraan dat het leven doorgaat, ondanks alle uitdagingen.</p><p>Ik ben dankbaar voor elke dag die ik heb en voor de mensen die me liefhebben en steunen. Samen zijn we sterker.</p><p>Voor iedereen die dit leest: blijf hoopvol en geloof in jezelf. Jij bent sterker dan je denkt.</p>',
            'date' => now('Europe/Amsterdam')->subDay(),
            'state' => 'published',
            'is_visible' => true, // Public post
        ]);

        // Create another public post
        BlogPost::create([
            'user_id' => $user->id,
            'subject' => 'Reflectie op de Week',
            'content' => '<p>Deze week heeft me veel geleerd over mezelf en over het leven. Soms voel je je overweldigd door alles wat er gebeurt, maar dan zijn er ook momenten van pure vreugde en dankbaarheid.</p><p>Ik heb geleerd dat het oké is om kwetsbaar te zijn en om hulp te vragen. We hoeven niet alles alleen te doen. Er zijn mensen die om ons geven en die willen helpen.</p><p>Deze reis heeft me ook geleerd om meer in het moment te leven. Niet te veel zorgen maken over morgen, maar genieten van vandaag. Elke dag is een geschenk.</p><p>Ik hoop dat mijn verhaal anderen kan inspireren om ook hun eigen kracht te vinden, wat er ook gebeurt in het leven.</p>',
            'date' => now('Europe/Amsterdam'),
            'state' => 'published',
            'is_visible' => true, // Public post
        ]);

        // Create a draft post (not shown anywhere yet)
        BlogPost::create([
            'user_id' => $user->id,
            'subject' => 'Concept: Toekomstplannen',
            'content' => '<p>Dit is een concept voor een toekomstige entry. Ik ben nog aan het nadenken over wat ik wil schrijven.</p><p>Misschien over mijn dromen en doelen voor de toekomst. Of over de lessen die ik heb geleerd tijdens deze moeilijke periode.</p><p>Ik wil dit nog wat meer uitwerken voordat ik het publiceer.</p>',
            'date' => now('Europe/Amsterdam'),
            'state' => 'draft',
            'is_visible' => false, // Draft posts are always private
        ]);

        $this->command->info('✅ BlogPostSeeder completed successfully!');
        $this->command->info('📧 User account created: dagboek@example.com');
        $this->command->info('🔑 Password: dagboek123');
        $this->command->info('📝 Created 4 sample posts (1 private, 2 public, 1 draft)');
    }
} 