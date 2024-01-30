<?php include $this->resolve("partials/_header.php"); ?>

<section class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <form enctype="multipart/form-data" action="<?php echo "/transaction/$id/receipt/" ?>" method="POST" class="grid grid-cols-1 gap-6">
        <?php include $this->resolve("partials/_token.php"); ?>
        <label class="block">
            <span class="text-gray-700">Receipt File (Image or PDF)</span>
            <input name="receipt" type="file" class="block w-full text-sm text-slate-500 mt-4 file:mr-4 file:py-2 file:px-8 file:border-0 file:text-sm file:font-semibold file:bg-violet-100 file:text-violet-700 hover:file:bg-violet-200" />
            <?php if (array_key_exists('receipt', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['receipt'][0]); ?>
                </div>
            <?php else : ?>
                <?php foreach ($errors as $key => $error) : ?>
                    <?php foreach ($error as $message) : ?>
                        <div class="bg-gray-100 mt-2 p-2 text-red-500">
                            <?php echo $message; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </label>
        <button type="submit" class="block w-full py-2 bg-indigo-600 text-white rounded">
            Submit
        </button>
    </form>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>