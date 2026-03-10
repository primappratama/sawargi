<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NodeStatus;

class NodeStatusSeeder extends Seeder {
    public function run(): void {
        $nodes = [
            ['node_id' => 'TX-01', 'node_name' => 'Lereng Nagrak',         'node_type' => 'TX'],
            ['node_id' => 'TX-02', 'node_name' => 'Talagaherang',          'node_type' => 'TX'],
            ['node_id' => 'TX-03', 'node_name' => 'Bojongsawah',           'node_type' => 'TX'],
            ['node_id' => 'RX-01', 'node_name' => 'Balai Desa Nagrakjaya', 'node_type' => 'RX'],
        ];

        foreach ($nodes as $node) {
            NodeStatus::updateOrCreate(
                ['node_id' => $node['node_id']],
                [...$node, 'is_online' => false]
            );
        }
        $this->command->info('✅ Node statuses initialized');
    }
}