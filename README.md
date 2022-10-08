腾讯云cos-v5

    $drive = Storage::disk(config('filesystems.default'));
    $res = $drive->cdn()->describePurgeTasks('428977402236957341');