import { CannotFindComponentError } from "../errors/CannotFindComponentError";

export const renameBlock = (zoneStore, blockId: string, newLabel: string) => {
  const block = zoneStore.content.find((block) => block.id === blockId);
  if (!block) throw CannotFindComponentError(blockId);
  block.label = newLabel;
};
