<?php

namespace App\Http\Modules\Tenants\Models;

use App\Http\Modules\DocumentTypes\Models\DocumentType;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;


    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'document_number',
            'logo',
            'active',
            'document_type_id',
            'user_created_id',
        ];
    }

    /**
     * Relationship with the document type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documentType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
