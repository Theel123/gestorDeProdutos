public function validateUserFromEntity(User $entity): void
    {
        if ($entity instanceof User && auth()->user()?->id !== $entity->getId()) {
            throw CustomerExceptions::differentUserRequestingData();
        }
    }
