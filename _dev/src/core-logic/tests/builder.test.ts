/* 
  Add a test here everytime you create a new builder or improve an existing one.
*/

import {
  buildNewBlockContentFromBlockStructure,
  buildNewComponentFromStructure,
  buildNewPrimitiveFieldFromStructure,
} from "../utils/builder";

import { BlockContent } from "../entities/BlockContent";
import { BlockStructure } from "../entities/BlockStructure";
import { ComponentContent } from "../entities/ComponentContent";
import { ComponentStructure } from "../entities/ComponentStructure";
import { PrimitiveFieldContent } from "../entities/PrimitiveFieldContent";
import { PrimitiveFieldStructure } from "../entities/PrimitiveFieldStructure";
import { PrimitiveFieldType } from "../entities/ElementType";
import columnBlockContent from "./newColumnContent.json";
import columnBlockStructure from "./columnStructure.json";

describe("Block, component and Primitive content builder", () => {
  let blockStructure: BlockStructure;
  let blockContent: BlockContent;
  beforeAll(() => {
    blockStructure = columnBlockStructure as BlockStructure;
    blockContent = columnBlockContent as BlockContent;
  });

  describe("Primitive builder", () => {
    it("builds a primitive text", () => {
      const primitiveTextStructure: PrimitiveFieldStructure<PrimitiveFieldType.TEXT> =
        blockStructure.fields
          .title as PrimitiveFieldStructure<PrimitiveFieldType.TEXT>;
      const expectedTextContent: PrimitiveFieldContent<PrimitiveFieldType.TEXT> =
        blockContent
          .fields[0] as PrimitiveFieldContent<PrimitiveFieldType.TEXT>;
      const newTextContent: PrimitiveFieldContent<PrimitiveFieldType.TEXT> =
        buildNewPrimitiveFieldFromStructure(
          primitiveTextStructure
        ) as PrimitiveFieldContent<PrimitiveFieldType.TEXT>;
      expect(newTextContent).toEqual(expectedTextContent);
      // TODO change comparison function to ignore id
    });
    it("builds a primitive number", () => {
      // TODO
    });
    // TODO implement all primitive builders and test them here
  });

  describe("Component builder", () => {
    it("builds a non-repeatable component", () => {
      const componentStructure: ComponentStructure = blockStructure.fields
        .banner as ComponentStructure;
      const expectedComponentContent: ComponentContent = blockContent
        .fields[1] as ComponentContent;
      const newComponentContent: ComponentContent =
        buildNewComponentFromStructure(componentStructure);
      expect(newComponentContent).toEqual(expectedComponentContent);
      // TODO change comparison function to ignore id
    });
    it("builds a repeatable component", () => {
      const componentStructure: ComponentStructure = blockStructure.fields
        .columns as ComponentStructure;
      const expectedComponentContent: ComponentContent = blockContent
        .fields[2] as ComponentContent;
      const newComponentContent: ComponentContent =
        buildNewComponentFromStructure(componentStructure);
      expect(newComponentContent).toEqual(expectedComponentContent);
      // TODO change comparison function to ignore id
    });
  });

  describe("Block builder", () => {
    it("builds a full block", () => {
      const newBlockContent: BlockContent =
        buildNewBlockContentFromBlockStructure(blockStructure);
      expect(newBlockContent).toEqual(blockContent);
      // TODO change comparison function to ignore id
    });
  });
});
