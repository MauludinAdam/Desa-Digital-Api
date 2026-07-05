<?php

// validation head of family
return [
            'required'                  => ':attribute harus diisi',
            'string'                    => ':attribute harus berupa string',
            'email'                     => ':attribute harus berupa email',
            'max'                       => ':attribute maksimal :max karakter',
            'min'                       => ':attribute maksimal :min karakter',
            'unique'                    => ':attribute sudah ada',
            'image'                     => ':attribute harus berupa gambar',
            'mimes'                     => ':attribute harus berupa png/jpg/jpeg',
            'exists'                    => ':attribute tidak ditemukan',
            'array'                     => ':attribute harus berupa array',
            'integer'                   => ':attribute harus berupa angka',
            'max:2048'                  => ':atribute harus maksima 2MB',
            'unique:users'              => ':attribute sudah ada',
            'in'                        => ':attribute harus berupa salah satu dari :values',
            'max:12'                    => ':attribute maksima :max angka',
            'exists:head_of_families'   => ':attribute Anggota Keluarga harus diisi',
            'exists:sosial-assistances' => ':attribute Anggota Keluarga harus diisi',
            'boolean'                   => ':attribute harus bernilai true atau false',
            'date'                      => ':attribute harus berupa tanggal',
            'date_format'               => ':attribute harus berupa waktu',
        ];
