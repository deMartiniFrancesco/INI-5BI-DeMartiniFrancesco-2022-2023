# -*- coding: utf-8 -*-
__author__ = "Francesco"
__version__ = "0101 2022/10/29"

import os

head, tail = os.path.split(__file__)
os.chdir(head)
os.chdir("../..")
os.chdir(os.getcwd())

label_path = ".github/labeler.yml"
dir_project_name = "demartini_F_"
src_path = "src/main/java/deMartiniFrancesco/projects"

default_label = \
    """documentation:
  - README.md

test:
  - src/test/java/*

library:
  - lib/*

workflows:
  - .github/workflows/*

resources:
  - src/main/resources/*

"""


def list_directory():
    return [
        directory for directory in os.listdir(src_path)
        if os.path.isdir(src_path + "/" + directory)
    ]


def labels_string(list_directory_name: list):
    string = ""
    directory: str
    for directory in list_directory_name:
        string += directory.replace(dir_project_name, "") + ":\n  - " + src_path + "/" + directory + "/*\n\n"
    return string


def write_labels(label_strings: str):
    try:
        file_labels = open(label_path, "w")

        file_labels.write(
            default_label +
            label_strings
        )
        file_labels.close()

    except IOError as error:
        print(error)
        return False
    return True


def read_labels_test():
    try:
        file_labels = open(label_path, "r")
        line: str
        for line in file_labels.readlines():
            print(line.strip("\n"))

        file_labels.close()

    except IOError as error:
        print(error)
        return False
    return True


boold = True
if __name__ == '__main__':
    if boold:
        print("Start")

    list_directories = list_directory()
    print("READ: ", read_labels_test())
    print("WRITE: ", write_labels(labels_string(list_directories)))
    print("READ: ", read_labels_test())

    if boold:
        print("End")
