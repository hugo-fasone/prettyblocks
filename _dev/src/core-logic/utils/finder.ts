import { ComponentContent, FieldContent } from "../entities/ComponentContent";

import { BlockContent } from "../entities/BlockContent";
import { Repeater } from "../entities/Repeater";

export type SearchComponentResult = {
  parent?: BlockContent | ComponentContent | Repeater<ComponentContent>;
  node: BlockContent | FieldContent;
};

export const findComponentById = (
  tree: BlockContent | ComponentContent,
  id: string
): SearchComponentResult => {
  // Check if block is searched id
  if (tree.id === id) return { node: tree };
  // Check if one of the current node fields matches the id
  const foundField = tree.fields.find((field) => field.id === id);
  if (foundField) return { node: foundField, parent: tree };
  // Check all repeater subfields
  return findComponentByIdInRepeaterFields(tree, id);
};

const findComponentByIdInRepeaterFields = (
  tree: BlockContent | ComponentContent,
  id: string
) => {
  const repeaterFields: Repeater<ComponentContent>[] = tree.fields.filter(
    (field) => field.type === "repeater"
  ) as Repeater<ComponentContent>[];
  for (const repeater of repeaterFields) {
    const foundElement = findComponentByIdInRepeater(repeater, id);
    if (foundElement) return foundElement;
  }
};

const findComponentByIdInRepeater = (
  repeater: Repeater<ComponentContent>,
  id: string
) => {
  for (const field of repeater.sub_elements) {
    // Check if subfield matches
    if (field.id === id) return { node: field, parent: repeater };
    // Else check recursively
    const foundElement = findComponentById(field, id);
    if (foundElement) return foundElement;
  }
};
